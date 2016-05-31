# How to set up working environment locally?

### Download and install
 - latest version of [Virtual box](https://www.virtualbox.org/wiki/Downloads)
 - latest version of [Vagrant](https://www.vagrantup.com/downloads.html)


##### ```Only for Windows```
 - add 'ssh' command to cmd:
 Open Properties of This PC (My Computer)
    -> Advanced System Settings
    -> Environment Variables
    -> Open PATH variable and add your path to ssh.exe in your custom installation of Git
    It should be something like: ``` C:\Program Files (x86)\Git\bin ```

### Clone repo locally and set up environment
```sh
$ git clone https://github.com/kakato10/vkusotiiki-bg.git
```

 - move to project working directory (OS X):
```sh
$ cd vkusotiiki-bg
```

 - open terminal / command line and type:
```sh
$ vagrant up
```
 - WAIT (do something else for about 30 - 60min depends on the machine and network signal). Last command will create a new virtual machine without GUI and will install all needed packages inside of it
 - After all finished, enter in the terminal /  command line:
```sh
$ vagrant ssh
```

### Now you're in the game!
Type
```sh
$ grunt serve
```
## Voilà!
