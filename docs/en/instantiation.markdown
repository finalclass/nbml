# Instantiation [instantiation]

In order to start working with nbml files, one has to initialise ViewAutoLoader. This class registers php autoloader,
so it can handle *.nbml file. It can be done using provided sandbox, or
manually.
It is also needed to initialise some autoloader to nbml library classes - because nbml uses standard method to load classes this action is left to the programmer. But at first lets' go to the easier 
variant - to start work using sandbox file [instantiation-sandbox].
