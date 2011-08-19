<?php
  include("template.class.php");

  $test = new Template("test.tpl");
  $test->set("users",
              array(
                array(
                  "username"=>"username1",
                  "firstname"=>"firstname1",
                  "test"=>array(
                    array(
                      "testdata"=>"test1"
                    ),
                    array(
                      "testdata"=>"test2"
                    )
                  )
                ),
                array(
                  "username"=>"username2",
                  "firstname"=>"firstname2",
                  "test"=>array(
                    array(
                      "testdata"=>"test3"
                    ),
                    array(
                      "testdata"=>"test4"
                    )
                  )
                ),
                array(
                  "username"=>"username3",
                  "firstname"=>"firstname3",
                  "test"=>array(
                    array(
                      "testdata"=>"test5"
                    ),
                    array(
                      "testdata"=>"test6"
                    )
                  )
                )    
              ));
  $test->set("content", "This is a sample paragraph");
  echo $test->output();
