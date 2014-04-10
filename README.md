Driver Insurability Rating Calculator
=====================

This provides an input form to enter sample values for an automobile driver and view the resulting rating score.
It's based on a 13-factor formula analyzing such things as driver's age, etc.

It can be run as a web page or to the terminal from command line.  There is also a battery of unit tests included.
To make these things easier, the user interface was separated from the business logic. The object-oriented/functional design provides modularity to mix-and-match components for different uses.

Notice the native PHP miniature "templating" with the heredoc style expressions in the echo statements.  These
support both embededed variables ("tags") and expressions in curly braces.
