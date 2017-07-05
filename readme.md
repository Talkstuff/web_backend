## About Talkstuff Web Backend

Ensure that for everytime you clone, do correct a bug I discovered in laravel's Illuminate\Console\GeneratorCommand.php file.

Replace the return statement for the 'qualifyClass' method to this:
return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;

The default one throws this error when working with Caffeinated modules:
Allowed memory size of 536870912 bytes exhausted