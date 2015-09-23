# PHP Masonry

PHP Masonry is a way of building up a service using blocks of functionality. Tasks are retrieved from a pool, and are
processed by workers. You can have any number of Workers, and any number of Tasks.

## Contents

 * [Task](#Task)
   * [Description](#description)
   * [Status](#task-status)
   * [History](#task-history)
     * [Event](#task-history-event)
     * [Result](#task-history-result)
     * [Reason](#task-history-reason)
 * [Pool](#pool)
   * [Status](#pool-status)
 * [Worker](#worker)
 * [Mediator](#mediator)
 * [Promise](#promise)

## Task

A task represents a piece of work that needs to happen. It tells you the history of the task, its current status, and
what it wants to happen, but does not specify how to do it.

```
╭────────────────────────────────╮
│ (i) Task                       │
├────────────────────────────────┤
│ <Description> getDescription() │ ← Description tells a worker what needs to happen
│ <Status>      getStatus()      │ ← The current status of the Task: 'new', 'in progress', 'complete', or 'deferred'
│ <History>     getHistory()     │ ← The history of the Task so far
╰────────────────────────────────╯
```

### Task - Description

Description is an empty interface simply used for control. It should be extended to provide the information require
for a specific task.

```
╭───────────────────────────────╮
│ (i) Task\Description          │
├───────────────────────────────┤
╰───────────────────────────────╯
```
For example, if you wanted a worker that could move files, you could define a MoveFile interface. The interface tells
you where the file is now, and where it should be. Your worker should then add the interface name (`MoveFile`) to it's
list of Descriptions it knows how to deal with, provided by `Worker::getDescriptionTypes()`.

```
╭───────────────────────────────╮
│ (i) MoveFile : Description    │
├───────────────────────────────┤
│ <string> fromLocation()       │
│ <string> toLocation()         │
╰───────────────────────────────╯
```

### Task - Status

The task maintains a reference in the [Task Pool](#Task-Pool) until it is complete. At any point a Task may be asked for
it's Status. A task may have one of four statuses.

 * `new`: The tasks has not been touched since it was created
 * `in progress` : The task has been removed from the pool to be processed
 * `complete` : The task has been processed. This does not specify whether the task succeeded or failed, that is
   covered by the [Result][#task-history]
 * `deferred` : The task has been attempted previously but for whatever reason has been put back in the queue.
```
╭────────────────────────────────╮
│ (i) Task\Status                │
├────────────────────────────────┤
│          __construct(<string>) │ ← Initialise the Status with: 'new', 'in progress', 'complete', or 'deferred'
│ <string> getStatus()           │ ← The string representation of the status
│ <string> __toString()          │ ← must return getStatus()
╰────────────────────────────────╯
```

### Task - History

The history is simply a collection of [Events](#task-history-event)

```
╭────────────────────────────╮
│ (i) Task\History           │
├────────────────────────────┤
│ <History> addEvent(<Event>)│ ← Add a new event to the history
│ <Event[]> getEvents()      │ ← Returns an array of all events
│ <Event>   getLastEvent()   │ ← Returns the last event or null if there is nothing in the history
╰────────────────────────────╯
```

#### Task - History - Event

A single event in the tasks history. A new event should be created when the [Task](#task) leaves the [Pool](#pool) to
be processed. The event is completed when the Pool is asked to complete or defer the task.

```
╭───────────────────────────────────────╮
│ (i) Task\History\Event                │
├───────────────────────────────────────┤
│ <Event>  startEvent()                 │ ← Events should only be created through this static method
├───────────────────────────────────────┤
│ <Event>  endEvent(<Result>, <Reason>) │ ← End the event with a Result, and optionally Reason
│ <float>  getStartTime()               │ ← Get the event start time. This should be the time the event was created
│ <float>  getEndTime()                 │ ← Get the end time or null if it's in progress
│ <Result> getResult()                  │ ← Always returns a Result, though it defaults to 'incomplete'
│ <Reason> getReason()                  │ ← Always returns a Reason, though it's empty by default
│ <string> __toString()                 │ ← Should return a string representation of the event for logging purposes
╰───────────────────────────────────────╯
```

#### Task - History - Result

The result of trying to process the [Task](#task), recorded against an [Event](#task-history-event) in
[History](#task-history).

```
╭────────────────────────────────╮
│ (i) Task\History\Result        │
├────────────────────────────────┤
│          __construct(<string>) │ ← Initialise the Result with a value: 'succeeded', 'failed' or 'incomplete'
│ <string> getResult()           │ ← The string representation of the result: 'succeeded', 'failed' or 'incomplete'
│ <string> __toString()          │ ← must return getResult()
╰────────────────────────────────╯
```

#### Task - History - Reason

The reason for the [Result](#task-history-result) of trying to process the [Task](#task), recorded against an
[Event](#task-history-event) in [History](#task-history). This is optional and can be any string. It is mostly useful
for logging failures.

```
╭────────────────────────────────╮
│ (i) Task\History\Reason        │
├────────────────────────────────┤
│          __construct(<string>) │ ← Initialise the Reason with any string value
│ <string> getReason()           │ ← The string representation of the Reason
│ <string> __toString()          │ ← must return getReason()
╰────────────────────────────────╯
```

## Pool

The Task Pool is designed to store and retrieve tasks. It could represent a queue, a stack, a heap or something else.

```
╭──────────────────────────╮
│ (i) Pool                 │
├──────────────────────────┤
│ <Pool>   addTask(<Task>) │ ← returns a reference to itself for chaining
│ <Task>   getTask()       │ ← get the next Task from the pool
│ <Status> getStatus()     │ ← tells you if the pool has tasks 'pending' or is 'empty'
╰──────────────────────────╯
```

### Pool - Status

The State of the Task Pool is represented by the Status Value Class. It could be in two states.
 1. `pending` There are tasks waiting to be processed
 2. `empty` There are no tasks waiting to be processed

Note: Tasks with the status `in progress` or `complete` should not be considered waiting.

```
╭────────────────────────────────╮
│ (i) Pool\Status                │
├────────────────────────────────┤
│          __construct(<string>) │ ← Initialise the Status with: 'pending' or 'empty'
│ <string> getStatus()           │ ← The string representation of the status
│ <string> __toString()          │ ← must return getStatus()
╰────────────────────────────────╯
```

## Worker

Workers are where the Tasks are processed. They may or may not be asynchronous and therefore should always return a
Promise.

Workers may also be able to handle multiple types of [Task Descriptions](#task-descriptions), and will therefore always
return an array of strings. The best practice, however, should be to have one worker per Task Description

```
╭──────────────────────────────────╮
│ (i) Worker                       │
├──────────────────────────────────┤
│ <Promise>  process(<Task>)       │ ← Workers always return Promises, regardless of whether they are asynchronous.
│ <string[]> getDescriptionTypes() │ ← This should return an array of Descriptions Types the worker knows how to handle.
╰──────────────────────────────────╯
```

## Mediator

The mediator is responsible for taking a task and passing it to the correct worker.

```
╭──────────────────────────────────╮
│ (i) Mediator                     │
├──────────────────────────────────┤
│ <Mediator> addWorker(<Worker>)   │ ← Inform the mediator about a Worker. Returns a reference to itself
│ <Promise>  process(<Task>)       │ ← Pass a task. This will return a promise from a Worker to do the task or throw an
╰──────────────────────────────────╯   exception if no appropriate Worker was found.
```

## Promise

Workers return React Promises. See the documentation here: https://github.com/reactphp/promise
