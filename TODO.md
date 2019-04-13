 - [ ] make `Terminal::setTitle` static
    - [ ] make `Terminal::isXterm` static
    - [ ] make `Terminal::isXtermTerminal` static
    - [ ] make `Terminal::checkEnvVariable` static
 - [ ] simplify adding new theme?
 
 ---
 
 - [x] split `Themes::class`
 - [x] function setTitle should work only in xterm - add checks [link](https://askubuntu.com/questions/774532/how-to-change-terminal-title-in-ubuntu-16-04) [link](https://unix.stackexchange.com/questions/177572/how-to-rename-terminal-tab-title-in-gnome-terminal/186167#186167) [link](https://askubuntu.com/questions/22413/how-to-change-gnome-terminal-title) 
 - [x] ~~simplify `ConsoleColour` class~~ removed
 - [x] unify tests
 - [x] ~~consider removing unnecessary `DOCKER_TERM` var~~ still needed