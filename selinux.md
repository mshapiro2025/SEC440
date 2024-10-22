# SELinux

## Lecture Notes: SELinux

### The Problem

#### Increases In...

* malware/security attacks
* system complexity
* network connectivity
* code sophistication
  * more active content
  * more mobile code

#### Zero-Days

* patch cycle
  * attackers find a vulnerability and develop an exploit
  * users/testers discover an exploit and develop a patch to negate the exploit
  * protecting the systems in the period between when the exploit is developed and when the patch is distributed is called the 0-day problem&#x20;

#### The Issue

* the problem:
  * how to defend against an exploit that hasn't been developed
* a possible solution:
  * control access to resources to limit exposure, and thus the chances for an exploit
  * manage access controls such that, if an exploit is successful, there is a strict limit on the resources available to the exploit

### Access Control

* Linux (and most other OSs) implement discretionary access control over resources
  * users have the discretion to allow or deny access to resources that they control
* if a process is compromised, it operates with the access controls given to that process (the user associated with the process)
* higher level security implements access control in the system (mandatory access control)
  * access to resources is managed by a security policy, not user decisions

### SELinux History

* mandatory access controls used in high security systems (military) for years
* NSA began work on embedding MAC into existing OSs
  * 1991-92: Mach OS
  * 1993-95: Distributed Trusted OS
  * 1998-99: Flux Advanced Security Kernel (FLASK)
  * 2000-? Security Enhanced Linux

### What is SELinux?

* a label based security system
* every process has a label and every object on the system has a label
* the SELinux policy controls how process labels interact with other labels on the system
* the kernel enforces the policy rules
  * policy database

### SELinux Terminology

* identity
  * similar to, but separate from user ID
  * su command changes user ID but not identity
    * policies in SELinux can retain original user ID for auditing
* domain
  * a list of what action sa process can perform
* type
  * a type of actions that can be performed on an object (similar to domain)
* role
  * defines what domains/types a user is allowed to access

### SELinux Labeling

* files, processes, ports, etc. are all labeled with an SELinux context
* for files and directories, these labels are stored as extended attributes on the file system
* for processes, ports, etc., the kernel manages these labels

### Types of Enforcement

* type enforcement
  * processes running in certain contexts can interact with objects with certain labels
    * ex. process with httpd\_t context can interact with file with httpd\_config\_t label
  * allow \[source] \[target]:\[class] \[permissions];

### Security Context

* a combination of user, role, and type
* essentially the "label"
  * what is the user?
  * what is their role?
  * what can they do?

### Security Model

* security context analysis:
  * similar to sentence diagramming
  * ex. subject, verb, object -> user, role (object), type/domain (action)
* each process is associated with a domain
  * a "sandbox" to limit or control its interactions
* each domain is associated with a security context
  * a combination of a resource and the actions allowed on that resource (read a file, execute a program, etc.)
* each resource (file, etc.) has a security context
  * processes can only act on resources if the security contexts specifically grant access

### SELinux Policy

* security context determined by system policy file
  * policy is a compiled file based on a text file that you define (or a default file that you use)
  * this defines all of the various file and user contexts that you want to be active in your system
  * compiled policy stored in /etc/selinux/targeted/policy
  * based on contexts in /etc/selinux/targeted/contexts

### SELinux Usage

* show SELinux status
  * sestatus
* set enforcement policy permissive/disabled
  * setenforce/getenforce
* set policy type
  * targeted (only monitor specific services and files)
  * strict (monitor everything)
  * defined in /etc/selinux/config
* if targeted, select policies for each service

### SELinux Commands

* security context control (file contexts)
  * checkpolicy
  * load\_policy
  * setfiles
  * restorecon
  * chcon
  * semanage
* targeted policy overrides
  * getsebool
  * setsebool
  * togglesebool

## Lab Notes: SELinux Red Hat Labs

### Guided Exercise: Change the SELinux Enforcement Mode

#### workstation

```
lab start selinux-opsmode
ssh student@serverea
sudo -i
# see SELINUX mode
getenforce
# edit SELINUX config file to change mode to 
nano /etc/selinux/config
# change SELINUX parameter from enforcing to permissive
grep '^SELINUX' /etc/selinux/config
setenforce 0
getenforce
# change SELINUX back to enforcing
nano /etc/selinux/config
# change SELINUX parameter from passive to enforcing
setenforce 1
getenforce
systemctl reboot
ssh student@servera
sudo -i
getenforce
exit
exit
lab finish selinux-opsmode
```

### Guided Exercise: Control SELinux File Contexts

#### workstation

```
lab start selinux-filecontexts
ssh student@servera
sudo -i
# configure apache to use a non-standard document directory
mkdir /custom
echo 'This is SERVERA' > /custom/index.html
nano /etc/httpd/conf/httpd.conf
# change DocumentRoot to "/custom" and <Directory "/custom">
systemctl enable --now httpd
systemctl status httpd
semanage fcontext -a \
> -t httpd_sys_content_t '/custom(/.*)?'
restorecon -Rv /custom
exit
exit
lab finish selinux-filecontexts
```

### Guided Exercise: Adjust SELinux Policy with Booleans

#### workstation

```
lab start selinux-booleans
ssh student@servera
sudo -i
nano /etc/httpd/conf.d/userdir.conf
# comment out UserDir disabled in IfModule mod_userdir.c
# uncomment UserDir public_html in IfModule mod_userdir.c
systemctl enable --now httpd
# open another terminal
ssh student@servera
mkdir ~/public_html
echo 'This is student content on SERVERA.' > ~/public_html/index.html
chmod 711 ~
ls -ld ~
# go back to other terminal
getsebool -a | grep home
setsebool -P httpd_enable_homedirs on
exit
exit
lab finish selinux-booleans
```

### Guided Exercise: Investigate and Resolve SELinux Issues

```
lab start selinux-issues
ssh student@servera
sudo -i
less /var/log/messages
# search for SELinux is preventing /usr/sbin/httpd from getattr access on the file /custom/index.html. For complete SELinux messages run: sealert -l [alert ID]
sealert -l [alert ID]
ls -ldZ /var/www/html
ausearch -m AVC -ts today
semanage fcontext -a -t httpd_sys_content_t '/custom(/.*)?'
restorecon -Rv /custom
exit
exit
lab finish selinux-issues
```

### Lab: Manage SELinux Security

<pre><code>lab start selinux-review
ssh student@serverb
sudo -i
less /var/log/messages
sealert -l [alert ID]
ls -ldZ /var/www/html
ls -ldZ /lab-content/lab.html
semanage fcontext -a -t httpd_sys_content_t '/lab-content.lab.html'restorecon -Rv /custom
restorecon -Rv /custom
<strong>exit
</strong>exit
lab grade selinux-review
lab finish selinux-review
</code></pre>

