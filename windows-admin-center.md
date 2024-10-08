# Windows Admin Center

## Lecture Notes: Windows Admin Center

### What is Windows Admin Center?

* a locally-deployed, browser-based management tool set that lets you manage your Windows clients, servers, and clusters without needing to connect to the cloud
* gives you full control over all aspects of your server infrastructure and is particularly useful for managing servers on private networks that are not connected to the Internet
* the modern evolution of in-box management tools like Server Manager and MCC
  * complements System Center, but isn't a replacement

### How Does WAC Work?

* install on a server/workstation (NOT on a DC)
  * free download
  * access via browser

### Installation Types

* local client
  * install on a local windows 10 client that has connectivity to the managed servers
  * great for quick start, testing, ad-hoc, or small scale scenarios
* gateway server
  * install on a designated gateway server and access from any client browser with connectivity to the gateway server
  * great for large-scale scenarios
* managed server
  * install directly on a managed server for the purpoes of remotely managing the server or a cluster in which it is a member node
  * great for distributed scenarios
* failover cluster
  * deploy in a failover cluster to enable high availability of the gateway service
  * great for production environments to ensure resiliency of your management service

### Extensions

* WAC is built as an extensible platform
  * enable partners and devs to leverage existing capabilities within WAC
  * integrate with other IT admin products and solutions
  * each tool in WAC is built as an extension

### WinRM

* Windows Remote Management
* enables connections between computers or servers so that remote operations can be performed
* can obtain data or manage resources on remote computers as well as the local computer
* connecting to a remote computer in a WinRM script is very similar to making a local connection
* the WinRM service starts automatically on servers since 2008
* however, by default, WinRM listener may not be configured, even if WinRM is running
  * Windows Defender may block ports
  * Windows 10/11 needs some help to be managed by WAC
