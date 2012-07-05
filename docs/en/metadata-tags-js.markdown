# Metadata Tags - Js [metadata-tags-js]

Functionality of [\[Js\]][metadata-tags-js] tag is identical with functionality of [\[Css\]][metadata-tags-css] tag with the exception, that it is responsible for adding JavaScript files.
It causes adding the following line in component's constructor:

	\Nbml\Component\Application::getInstance()->scripts()->add('file.js');

