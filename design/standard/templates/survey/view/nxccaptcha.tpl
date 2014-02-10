{ezcss_require( array( 'nxc.captcha.css' ) )}
<script src="/extension/nxc_captcha/design/standard/javascript/nxc.captcha.js"></script>

<div class="survey-choices">
   <label><span class="question-number">{$question.question_number}.</span> {$question.text|wash('xhtml')} {if $question.mandatory}<strong class="required">*</strong>{/if}</label>

	<p>{'To prevent spamming, please enter the secure code you see in the image below in the input box beneath the image.'|i18n( 'extension/nxc_captcha' )}</p>
	<img id="nxc-captcha-{$attribute_id}" alt="{'Secure code'|i18n( 'extension/nxc_captcha' )}" title="{'Secure code'|i18n( 'extension/nxc_captcha' )}" src="{concat( 'nxc_captcha/get/', -1, '/nxc_captcha_survey_attribute_', $attribute_id, '/0' )|ezurl( 'no' )}" />


	<p>
		<a href="{concat( 'nxc_captcha/get/', -1, '/nxc_captcha_survey_attribute_', $attribute_id, '/1' )|ezurl( 'no' )}" class="nxc-captcha-regenerate" id="nxc-captcha-regenerate-{$attribute_id}">{'Regenerate'|i18n( 'extension/nxc_captcha' )}</a>
		<input class="captcha-input" id="nxc-captcha-input-{$attribute_id}" type="text" name="{$prefix_attribute}_ezsurvey_answer_{$question.id}_{$attribute_id}" value="" size="" maxlength="" />
	</p>
	
   {* <input type="hidden" name="{$prefix_attribute}_ezsurvey_answer_{$question.id}_{$attribute_id}" value=""> *}
 </div>