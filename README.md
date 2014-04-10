Driver Insurability Rating Calculator
=====================

This simple web app provides an input form to enter sample values for a 13-factor formula and see the resulting
scores.

Note that it can be run as a web page or to the terminal from command line.  It can also be run as a unit test
and there is a battery of unit tests included.

The object-oriented design isn't overly complex, but it makes the application very flexible and modular for these
different purposes/modes: testing, debugging, plugging into other applications, changing the user interface, etc.

It could be written in an old-fashioned procedural style, but it would likely require a series of include files
and conditional expressions driven by global variables.  It would be difficult to trace the flow in such a patchwork
of alternating blocks.  Functional/object-oriented programming is so much more naturally modular; each function
receives input and passes output.  There can be a little duplication, but there is clarity.

Notice the native PHP miniature "templating" with the heredoc style expressions in the echo statements.  These
support both embededed variables ("tags") and expressions in curly braces.  PHP provides its own wonderful, native
low-tech "templating" system for small projects.

This small app also separates the user interface code from the business logic - not by source file - but by
function - which is just as good for this purpose.  As mentioned, this allows us to run in different output
modes and to test the calculations independent of the interface.
