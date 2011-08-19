PHP Simple Templates
====================

This is a simple templating class derived from a [brocolos.net blogpost by Nuno Feitas](http://www.broculos.net/en/article/how-make-simple-html-template-engine-php). I modified it to allow for lists of itmes to be displayed without the need for a separate template file.

To see the example in action, download the files to a server and view test.php.

Usage
=====

You'll need three files to use the class:
* data file (test.php)
* template file (test.tpl)
* template class file (template.class.php)

Creating your template
----------------------

As far as special markup goes, there's only one thing to learn: [@mytag] and optionally [/@mytag].

If you're only replacing one value in the template, you only need to use [@mytag].

If you have a list of items you would like to be displayed, you can loop through them by wrapping them in [@mytag]content[/@mytag].

Like so:

<table>
  [@users]
  <tr>
   <td>[@firstname]</td><td>[@lastname]</td> 
  </tr>
  [/@users]
</table>

The above code will loop through all of the users (provided by the data file) and replace them with their respective values. This is recursive, so you can nest to your heart's content.

Creating your datafile
----------------------

1. Include the template class. (`include("template.class.php");`)
2. Create a new object from that class that points to your template file. (`$myPage = new Template("myTemplateFile.tpl");`)
3. Set the values. 
`$myPage->set("firstname", "John");
  $myPage->set("lastname", "Doe");

  And for lists of values:
  $myPage->set("values", array(
    array(
      "firstname"=>"John",
      "lastname"=>"Doe"
    ),
    array(
      "firstname"=>"Jane",
      "lastname"=>"Doe"
    )
  );

  You can nest the arrays as much as you like.`
4. Display. (`$myPage->output();`)
