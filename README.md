# Bower config mergetool

This tool helps developer to use one ```bower.json``` file, instead of multiple ones.

Consider following situation. Your project has custom bower.json file. You install some dependencies using composer. 
Each of them has his own ```bower.json``` file. How to manage it?

This tool can crawl ```vendor``` directory. It reads each of ```bower.json``` file and merge dependencies into 
main ```bower.json``` file.

To use this tool, install ```bower-config-mergetool```:

```
composer require filipgolonka/bower-config-mergetool:dev-master
```

and just add following lines to your ```composer.json``` file:

```
  "scripts": {
    "post-install-cmd": [
      "STP\\Bower\\ConfigMergeTool::mergeConfig",
      "npm install"
    ],
    "post-update-cmd": [
      "STP\\Bower\\ConfigMergeTool::mergeConfig",
      "npm install"
    ]
  }
```
