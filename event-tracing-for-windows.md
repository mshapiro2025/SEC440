# Event Tracing for Windows

## Lecture Notes: Event Tracing for Windows (ETW)

### Event Tracing for Windows

* high speed tracing facility built into Windows which is using a buffering and logging mechanism implemented directly into the OS kernel
* infrastructure for events raised by both user mode (apps) and kernel mode components (drivers)
* originally made for devs to see app performance and for debugging
* EDR systems utilize ETW
  * doesn't downgrade the performance of your system

### ETW Architecture

* major components and responsibilities:
  * providers: generate ETW events (ex. drivers, applications, Windows kernel)
  * controllers: start/stop/configure the logging
  * consumers: logging, analyzing, or processing the events
  * sessions: records events from provider(s)

### Artifacts: Location and Type

* location: no specific location
* file type: stored on disk end with the .etl (Event Trace Logging) extension

### Forensic Value of ETW

* system and app diagnosis
* troubleshooting
* performance monitoring
* detection

### Tools&#x20;

#### logman

* creates and manages Event Trace Session and Performance logs and supports many functions of Performance Monitor from the command line

#### PerfView

* a free performance analysis tool that helps isolate CPU and memory-related performance issues

#### Windows Performance Recorder and Windows Performance Analyzer

* WPR
  * used to record sessions
* WPA
  * used to analyze recorded sessions

#### EtwExplorer

* view ETW provider metadata
  * GUID
