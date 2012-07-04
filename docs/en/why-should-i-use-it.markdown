# Why should I use the nbml? [why-should-i-use-it]

PHP is a language, that is itself a system of templates. Writing websites 
utilizing pure html+js+css is the best solution. The problem is, that if you separate view from controller in PHP, the views are not precise, that means it's unknown what variables can the template accept. IDE is not able to prompt, what can be executed in given template. The coder doesn't know, what variables have been left to him by programmer.

Here the nbml comes to aid. Thanks to him we are still creating templates in HTML+PHP, but this time the contract between 
coder and programmer is clear. The coder knows what does he have in particular view, and the programmer is happy because he
has an object:) Nobody will ever confuse variables names, because IDE without problems parses
generated classes
and prompts available options and variables' types.

Thanks to this solution you get full **objected view**. You create a tree of light components. But you create it in HTML - so applying skins is trivial.
This solution is completely non-invasive and you can without any counter-indications use 
nbml, parallel
with other libraries.
