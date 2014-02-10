
	nxc captcha works like this:

.tpl renders <img src="/nxc_captcha/get/<(int)attrribute_id>/<(string)session_key_pattern>/<(bool)regenerate>
On post, checks the session_key_pattern and post_input_pattern VALUES to be equal or not.
Session var is removed if valid

The NXC Captcha has been modified to allow a new nxc_captcha.ini.append.php with system wide default settings
This allows the get.php to accept a special '-1' value for attribute and generate an image, set a session var without an object attribute.

The NXC Captcha Survey Type uses the nxc_captcha/get/-1/<survey_question_attribute_id>/0 syntax
	
The regenerate link is Javascript, that refreshes the <img> src with a regenerate 1 and random math value, thereby creating a new image and setting new session variable
Becuase session variables are stored on the server the captcha is a 1-time use token.
