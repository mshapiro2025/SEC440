# Microsoft AppLocker

## Lecture Notes: Microsoft AppLocker

* introduced in Windows 7 and Server 2008 R2
* allows you to allow or block certain applications for users and groups based on unique file identities
  * AppLocker Rules
* helps mitigate against using unknown applications in your environment
* AppLocker is designed to enhance security, but not a security measure on its own and is not meant to replace firewalls, EDRs, AVs, etc.
* provides an additional layer in a defense-in-depth strategy

### Application Whitelisting

* a proactive technique where only a limited number of programs are allowed to run, while all other programs are blocked from running by default

### Application Blacklisting

* a technique where certain programs are not allowed to run, while all other programs are allowed to run by default

### Usage Examples

* email that includes a hidden program to be executed
* website that silently exploits a vulnerability in the web browser adn tries to run an add-on or download and run a program from the browser
* opening a malicious document that tries to execute a malicious program
* trying to run applications from removable media
* trying to install an application without an administrator being aware

### AppLocker Rule Types

* file hash
* path
* publisher

### Applications Controlled by AppLocker

* executables
  * EXE
  * COM
* scripts
  * ps1
  * bat
  * cmd
  * vbs
  * js
* installers
  * msi
  * msp
  * mst
* DLLs
  * dll
  * ocx
* packaged apps
  * appx

### Limitations

* does not provide protections against files already opened in memory for non-execute
* not suitable for businesses where application installation is not centralized and goes through an approval process
