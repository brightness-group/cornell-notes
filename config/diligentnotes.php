<?php

return [

    'demo' => [
        'folder' => [
            [
                'name' => 'Welcome',
                'welcome' => true,
                'note' => [
                    [
                        'title' => 'Diligent Notes',
                        'content' => [[
                            "cue" => "<h2>Cue Section</h2><p>&nbsp;</p><p>Write main cues, ideas, or topics as prompts for your memory.</p><p>&nbsp;</p><p>&nbsp;</p><p>This is a good place to anticipate exam questions</p><p>&nbsp;</p><p>Main people or ideas</p><p>&nbsp;</p><p>Vocabulary words</p><p>&nbsp;</p><p>This sections should prompt you to recall things from your notes section.</p><p>&nbsp;</p><p>Use the \u201cblur\u201d button on the top navigation bar to hide your notes</p><p>&nbsp;</p><p>You can also export and share your notes with friends.</p><p>&nbsp;</p><p>Use the formatting buttons to make the notes your own.</p><p>&nbsp;</p><p>We also have a file manager on the left hand side so you can organize your notes.</p><p>&nbsp;</p><p>Collapse the file manager using the arrow buttons</p>",

                            "note" => "<h2 style=\"text-align:center;\">Notes Section</h2><p style=\"text-align:center;\">&nbsp;</p><p>Thanks for signing up for Diligent Notes. &nbsp;Diligent Notes allows you to take Cornell Style notes online. &nbsp;We are excited to support you. &nbsp;If at any point you need help please reach out to us via email at <i><strong>support[at]diligentnotes.com</strong></i></p><p>&nbsp;</p><p>If you aren't familiar with Cornell style notes, we've tried to give clear instructions below. &nbsp;Start with this <strong>Notes </strong>section, then move to the <strong>Cue</strong> section to cover al of the main points you need in order to remember.</p><p>&nbsp;</p><p>This is the Notes Section.</p><p>&nbsp;</p><h3>These notes are your main points</h3><ul><li>Take them during class or lectures</li><li>Use whatever format you like</li></ul><p>&nbsp;</p><p>You can use numbered lists</p><ol><li>Important Fact 1</li><li>Important Fact 2</li><li><span style=\"background-color:hsl(60,75%,60%);\">Highlight things that are really important</span></li></ol><ul class=\"todo-list\"><li><label class=\"todo-list__label\"><input type=\"checkbox\" disabled=\"disabled\"><span class=\"todo-list__label__description\">Checklist Item 1</span></label></li><li><label class=\"todo-list__label\"><input type=\"checkbox\" disabled=\"disabled\"><span class=\"todo-list__label__description\">Checklist Item 2</span></label></li></ul><p>&nbsp;</p><blockquote><p><span st yle=\"background-color:hsl(0,0%,100%);\">Add quotes for better recall</span></p></blockquote><p>&nbsp;</p><p><span st yle=\"background-color:hsl(0,0%,100%);\">You can also add pictures with the <img src=\"".env('APP_URL')."/images/demo/default.png\"></span> icon above. &nbsp;In fact, you can add videos, <a href=\"google.com\">links</a>, google.com&nbsp;</p><p><img class=\"image_resized\" style=\"width:20.47%;\" src=\"".env('APP_URL')."/images/demo/dog.jpg\"></p>",

                            "summary" => "<h2>Summary</h2><p>Summarize your notes from the page above to reinforce your learning.&nbsp;</p><p>&nbsp;</p><p>Thanks for signing up with Diligent Notes. &nbsp;We love feedback. &nbsp;Email us at feedback[at]diligentnotes.com</p>"
                        ]],
                    ],
                ],
            ],
            [
                'name' => 'Demo',
                'welcome' => false,
                'note' => [
                    [
                        'title' => 'Diligent Notes',
                        'content' => [[
                            "cue" => "<h2>Cue Section</h2><p>&nbsp;</p><p>Write main cues, ideas, or topics as prompts for your memory.</p><p>&nbsp;</p><p>&nbsp;</p><p>This is a good place to anticipate exam questions</p><p>&nbsp;</p><p>Main people or ideas</p><p>&nbsp;</p><p>Vocabulary words</p><p>&nbsp;</p><p>This sections should prompt you to recall things from your notes section.</p><p>&nbsp;</p><p>Use the \u201cblur\u201d button on the top navigation bar to hide your notes</p><p>&nbsp;</p><p>You can also export and share your notes with friends.</p><p>&nbsp;</p><p>Use the formatting buttons to make the notes your own.</p><p>&nbsp;</p><p>We also have a file manager on the left hand side so you can organize your notes.</p><p>&nbsp;</p><p>Collapse the file manager using the arrow buttons</p>",

                            "note" => "<h2 style=\"text-align:center;\">Notes Section</h2><p style=\"text-align:center;\">&nbsp;</p><p>This is the Diligent Notes Demo. &nbsp;Diligent Notes is the best way to create Cornell Style Notes online. &nbsp;<strong>Feel free to play around with this document. &nbsp;We won't save anything you create - this is to test drive the application.</strong></p><p>&nbsp;</p><p>If you aren't familiar with Cornell style notes, we've tried to give clear instructions below. &nbsp;Start with this <strong>Notes </strong>section, then move to the <strong>Cue</strong> section to cover all of the main points you need in order to remember.</p><p>&nbsp;</p><p>This is the Notes Section.</p><p>&nbsp;</p><h3>These notes are your main points</h3><ul><li>Take them during class or lectures</li><li>Use whatever format you like</li></ul><p>&nbsp;</p><p>You can use numbered lists</p><ol><li>Important Fact 1</li><li>Important Fact 2</li><li><span st yle=\"background-color:hsl(60,75%,60%);\">Highlight things that are really important</span></li></ol><ul class=\"todo-list\"><li><label class=\"todo-list__label\"><input type=\"checkbox\" disabled=\"disabled\"><span class=\"todo-list__label__description\">Checklist Item 1</span></label></li><li><label class=\"todo-list__label\"><input type=\"checkbox\" disabled=\"disabled\"><span class=\"todo-list__label__description\">Checklist Item 2</span></label></li></ul><p>&nbsp;</p><blockquote><p><span st yle=\"background-color:hsl(0,0%,100%);\">Add quotes for better recall</span></p></blockquote><p>&nbsp;</p><p><span st yle=\"background-color:hsl(0,0%,100%);\">You can also add pictures with the <img src=\"".env('APP_URL')."/images/demo/default.png\"></span> icon above (but we disabled it in this demo). &nbsp;In fact, you can add videos, <a href=\"google.com\">links</a>, and other common text features.</p><p>&nbsp;</p>",

                            "summary" => "<h2>Summary</h2><p>Summarize your notes from the page above to reinforce your learning.&nbsp;</p><p>&nbsp;</p><p>Thanks for signing up with Diligent Notes. &nbsp;We love feedback. &nbsp;Email us at feedback[at]diligentnotes.com</p>"
                        ]]
                    ],
                ],
            ],
        ],
    ],

    'default' => [
        'folder' => 'Default',
    ],
];
