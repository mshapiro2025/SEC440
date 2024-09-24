# Web Application and Database Redundancy

## Lecture Notes: Standard Replication and Galera Cluster

### Purpose and Advantages of Replication

#### Standard Replication for Maintenance

* backups
  * continuous
  * without locking tables (no performance drain)
* upgrades and schema changes
  * set slave to read-only&#x20;
  * make slave master
* redirect traffic away from master to slave - new master
* apply changes to original master
* redirect traffic back to master

#### Standard Replication for High Availability

* master fails
  * network outage
  * physical problems
* swappable database servers
  * redirect traffic to slave

#### Replication for Load Balancing

* distribute read traffic
  * move slow, heavy queries to slave
* redirect for maintenance
  * take slave offline for backups
  * direct away from failed servers
  * redirect traffic while upgrading

#### Enhanced Replication with Galera Cluster

* multiple masters
* transactional
* writes
  * conflict detection and resolution upon commit
  * nodes isolated easily
* seamlessly remove and add servers
  * automatic provisioning

### Option 1: Standard Replication

#### Standard Replication: Basic Replication Elements and Process

* master
  * handles client writes (possibly also reads)
  * daemon sends writes to storage engines
  * write queries recorded in binary log
  * sends binary log entries to slave (when asked)
* slaves
  * handles only client reads
  * queries master for binary log entries writes to storage engines and relay log

### Configuring Standard Replication

#### Standard Replication: Replication Threads

* master dump thread
  * sends binary log entries to slave
* slave IO thread
  * requests and receives master binary log entries
  * writes entries to its relay lg
* slave SQL thread
  * reads relay log and executes queries locally
  * checks query result codes match master
* multiple execution threads on slave
  * separate entries by database
  * updates applied in parallel (not sequence)

#### Standard Replication: Replication Files

* master binary log files
  * master records write to file
  * rotated when flushed or periodically to new log file
* slave relay log file
  * log of master binary log entries rotated periodically or when flushed
* replication configuration stored in master.info (slave)
* name of relay log file in relay-log.info (slave)

### Option 2: Galera Cluster

#### Galera Cluster Features

* virtual synchronous replication
* true multi-master solution
* almost no slave lag
* conflict detection and resolution on commit
* easy maintenance
  * automatic provisioning
  * node isolation
  * rolling upgrades

#### Data Centric

* data doesn't belong to a node, node belongs to data
* data is synchronized among multiple nodes
* galera nodes are anonymous (equal)
* galera cluster is a distributed master

#### Node Provisioning Tool

* state transfers for new nodes
  * State Snapshot Transfer (SST)
  * Incremental State Transfers (IST)
* methods for state transfers
  * logical- mysqldump
  * physical- rsync

## Project 3 Notes

### Configuring Ubuntu Database Servers

* snapshot
* change network adapter to LAN

<figure><img src=".gitbook/assets/{820E4AF9-7983-45CD-8885-A4EC05EBCB0C}.png" alt=""><figcaption></figcaption></figure>

<figure><img src=".gitbook/assets/{50CF2B39-D270-47CC-80AC-505D5F726537}.png" alt=""><figcaption></figcaption></figure>

<figure><img src=".gitbook/assets/{8EE665E6-563B-4435-B1A7-D90DAE39DA46}.png" alt=""><figcaption></figcaption></figure>

```
sudo adduser shapiro
sudo usermod -aG sudo shapiro
sudo hostnamectl set-hostname u1-shapiro/u2-shapiro/u3-shapiro
sudo nano /etc/netplan/00-installer-config.yaml
sudo netplan apply
reboot
```

<figure><img src=".gitbook/assets/{CC2FBC75-A43A-4D14-A782-403BB2C8B719}.png" alt=""><figcaption><p>/etc/netplan/00-installer-config.yaml for u1-shapiro</p></figcaption></figure>

<figure><img src=".gitbook/assets/{C7F32521-8342-452B-B861-0999C14FF291}.png" alt=""><figcaption><p>/etc/netplan/00-installer-config.yaml for u2-shapiro</p></figcaption></figure>
