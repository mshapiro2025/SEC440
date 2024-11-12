# Zeek

## Lecture Notes: Using Zeek for Network Investigations

### What is Zeek?

* a passive, open-source network traffic analyzer
* primarily a security monitor that inspects all traffic on a link in depth for signs of suspicious activity
* started in 1995 at Lawrence Berkeley National Laboratory with the support of the Department of Energy

### Usage

* could be used for:
  * network security monitoring
  * intrusion detection
  * network investigations
  * developing solutions
  * research

### Supported Protocols

* supported protocols include (but are not limited to):
  * DHCP
  * DNS
  * FTP
  * HTTP
  * IRC
  * POP3
  * SMTP
  * SOCKS
  * SSH
  * SSL
  * SYSLOG
  * GTPv1
  * SMB
  * Teredo

### How It Works

* network -> (packets) -> event engine -> (events) -> policy script interpreter -> (logs and notifications) ->
  * on the network is a tap device to capture the packets

### Working Details

* by default, when Zeek sees network traffic using an application protocol it knows about, it will log the details of those transactions in a .log file
* gives you a mechanism to create custom logic to&#x20;

### Quick Configs

* $PREFIX/etc/node.cfg
  * monitoring interface
* $PREFIX/etc/networks.cfg
  * configure the monitored environment
* $PREFIX/etc/broctl.cfg or zeekctl.cfg
  * configure the email address to receive messages and a desired log archival frequency

### Deployment

* ZeekControl
  * zeekctl
  * \[ZeekControl] > install
  * \[ZeekControl] > start

### Data Storage

* generated and stored logs will be found under $PREFIX/logs/current
  * every hour, current logs are truncated and new logs get created

### Additional Logs

* weird.log
  * unusual or exceptional activity that can indicated malformed connections or traffic that doesn't conform to a particular protocol
* notice.log
  * identifies specific activity that Zeek recognizes as potentially interesting, odd, or bad

### Using Zeek

* monitoring live network traffic
  * zeek -i \[interface]
* analyzing captures
  * zeek -Cr capture.pcap

### Calling Scripts

* default searching paths
  * current working directory
  * $PREFIX/share/zeek
  * $PREFIX/share/policy
  * $PREFIX/share/site
* zeek -Cr capture.pcap script.bro
* zeek -Cr capture.pcap /path/to/scripts
  * must have \_\_load\_\_.bro defined to say what the scripts to load are

### Filtering

* cat \[file].log | zeek-cut \[field 1] \[field 2] \[field 3]
* can add sort -r | uniq -c to sort for unique values in a field
