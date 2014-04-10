Insurability Rating Calculator
=====================

This simple web app provides an input form to enter sample values for a 13-factor formula and see the resulting
scores.

Note that it can be run as a web page or to the terminal from command line.  There is also a battery of unit
tests included.  To make these things easier, the user interface was separated from the business logic.
The object-oriented/functional design provides modularity to mix-and-match components for different uses.

Notice the native PHP miniature "templating" with the heredoc style expressions in the echo statements.  These
support both embededed variables ("tags") and expressions in curly braces.  PHP provides its own wonderful, native
low-tech "templating" system for small projects.
