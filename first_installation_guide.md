# How to set up working environment locally?

### Download and install
 - latest version of [Virtual box](https://www.virtualbox.org/wiki/Downloads)
 - latest version of [Vagrant](https://www.vagrantup.com/downloads.html)

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
