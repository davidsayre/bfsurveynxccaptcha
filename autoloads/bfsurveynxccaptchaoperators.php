 <?php
class BFSurveyNXCCaptchaOperators
{
    function BFSurveyNXCCaptchaOperators()
    {
    }

    function operatorList()
    {
        return array( 'recaptcha_form');
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
       return array( 'recaptcha_form' => array() );
                                              
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'nxc_captcha_input':
            {   			
				$surveyAttributeID = $namedParameters['survey_attribute_id'];
								
				//set session variable using 'nxc_captcha_survey_attribute_' + surveyAttributeId
				
				//TODO: render nxc captcha input using nxc_captcha/get/<surveyAttributeId>/<session_key>/<regenerate>
    			$operatorValue = 'TODO';
                break;
                
            } break;
        }
    }
}
?>
 