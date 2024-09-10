# Web and Proxy Redundancy

## High Availability Web Server

### HAProxy

* free and open source high availability load balancer software (not a hardware load balancer)
* reputation as fast, efficient, and stable
* used by some of the most hig profile sites
  * Github
  * Stack Overflow
  * Twitter
  * Slack
  * Reddit
* typically installed on minimal Linux server installs like RHEL, Cent, and Ubuntu
* TLS offloader: device (could be part of a load balancer) that acts as a gateway (usually in high-classified environments) that shows all traffic decrypted
  * installs a certificate in your browser so that everything going back and forth between your device and the Internet goes through this device in the center, which decrypts all traffic so it can be inspected, then encrypts it again and forwards it

### Keepalived

* relies on the well-known and widely used Linux Virtual SErver (IPVS) kernel module, which provides layer 4 load balancing
* Keepalived implements a set of health checkeres to dynamically and adaptively maintain and manage load balanced server pools according to their health
* high availability is achieved by the Virtual Redundancy Routing Protocol (VRRP)

<figure><img src=".gitbook/assets/image (14).png" alt=""><figcaption></figcaption></figure>

## Project 2: Web Redundancy

