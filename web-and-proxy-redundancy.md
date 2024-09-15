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

<figure><img src=".gitbook/assets/image (14) (1).png" alt=""><figcaption></figcaption></figure>

## Project 2: Web Redundancy

### HA1 Config

* snapshot
* set network adapter to OPT

<figure><img src=".gitbook/assets/image.png" alt=""><figcaption></figcaption></figure>

```
sudo adduser shapiro
sudo usermod -aG sudo shapiro
sudo hostnamectl set-hostname ha1-shapiro
reboot
sudo nano /etc/netplan/00-installer-config.yaml
sudo netplan apply
```

<figure><img src=".gitbook/assets/image (1).png" alt=""><figcaption></figcaption></figure>

### HA2 Config

* snapshot
* set network adapter to OPT

<figure><img src=".gitbook/assets/image (2).png" alt=""><figcaption></figcaption></figure>

```
sudo adduser shapiro
sudo usermod -aG sudo shapiro
sudo hostnamectl set-hostname ha2-shapiro
reboot
sudo nano /etc/netplan/00-installer-config.yaml
sudo netplan apply
```

<figure><img src=".gitbook/assets/image (3).png" alt=""><figcaption></figcaption></figure>

### WEB02 Config

* snapshot
* set network adapter to LAN

<figure><img src=".gitbook/assets/image (4).png" alt=""><figcaption></figcaption></figure>

```
sudo adduser shapiro
sudo passwd shapiro
sudo usermod -aG wheel shapiro
sudo nmtui
sudo yum install httpd
sudo nano /var/www/html/index.html
sudo systemctl enable httpd
sudo systemctl restart httpd
sudo firewall-cmd --add-port=80/tcp --permanent
sudo firewall-cmd --reload
```

<figure><img src=".gitbook/assets/image (5).png" alt=""><figcaption></figcaption></figure>

### Installing and Configuring HAproxy

#### HA1

```
sudo apt-get update
sudo apt-get install haproxy
sudo nano /etc/default/haproxy
# set ENABLED=1
sudo cp /etc/haproxy/haproxy.cfg /etc/haproxy/haproxy.bak
sudo nano /etc/haproxy/haproxy.cfg
# make changes to defaults section- mode and option to tcp
# add frontend and backend sections
sudo haproxy -f /etc/haproxy/haproxy.cfg -c
sudo systemctl start haproxy
```

<figure><img src=".gitbook/assets/image (7).png" alt=""><figcaption></figcaption></figure>

#### HA2

```
sudo apt-get update
sudo apt-get install haproxy
sudo nano /etc/default/haproxy
# set ENABLED=1
sudo cp /etc/haproxy/haproxy.cfg /etc/haproxy/haproxy.bak
sudo nano /etc/haproxy/haproxy.cfg
# make changes to defaults section- mode and option to tcp
# add frontend and backend sections
sudo haproxy -f /etc/haproxy/haproxy.cfg -c
sudo nano /etc/sysctl.conf
# add net.ipv4.ip_nonlocal_bind=1
sudo sysctl -p
sudo systemctl start haproxy
```

### Installing and Configuring Keepalived

#### HA1

```
sudo apt-get update
sudo apt install keepalived
sudo nano /etc/init.d/keepalived.conf
sudo mkdir -p /etc/keepalived
sudo nano /etc/keepalived/keepalived.conf
```

<figure><img src=".gitbook/assets/image (8).png" alt=""><figcaption><p>/etc/init.d/keepalived.conf</p></figcaption></figure>

<figure><img src=".gitbook/assets/image (16).png" alt=""><figcaption></figcaption></figure>

#### HA2

```
sudo apt-get update
sudo apt install keepalived
sudo nano /etc/init.d/keepalived.conf
sudo mkdir -p /etc/keepalived
sudo nano /etc/keepalived/keepalived.conf
```

<figure><img src=".gitbook/assets/image (15).png" alt=""><figcaption></figcaption></figure>

### VYOS

```
delete nat destination rule 10 translation address 10.0.5.100
set nat destination rule 10 translation address 10.0.16.10
commit
save
```

### Resources

{% embed url="https://www.digitalocean.com/community/questions/navigating-high-availability-with-keepalived" %}

{% embed url="https://www.haproxy.com/documentation/haproxy-configuration-tutorials/core-concepts/backends/" %}

{% embed url="https://www.digitalocean.com/community/tutorials/how-to-set-up-highly-available-haproxy-servers-with-keepalived-and-reserved-ips-on-ubuntu-14-04" %}

{% embed url="https://serverfault.com/questions/377529/haproxy-cannot-bind-socket-for-proxy-on-a-remote-machine" %}

### Reflection

* script "pidof haproxy" fails- use "pgrep haproxy"
