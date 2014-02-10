<?php
class eZSurveyNXCCaptcha extends eZSurveyQuestion
{
  /*
   * constructor
   */
  function __construct( $row = false )
  {
     $row[ 'type' ] = 'NXCCaptcha';
     $this->eZSurveyQuestion( $row );
  }
 
   /*
     * called when a question is created / edited in the admin
     * In this case we only have to save the question text and the mandatory checkbox value
     */
   function processEditActions( &$validation, $params )
   {
       $http = eZHTTPTool::instance();
       $prefix = eZSurveyType::PREFIX_ATTRIBUTE;
       $attributeID = $params[ 'contentobjectattribute_id' ];
 
       //title of the question
       $postQuestionText = $prefix . '_ezsurvey_question_' . $this->ID . '_text_' . $attributeID;
       if( $http->hasPostVariable( $postQuestionText ) and $http->postVariable( $postQuestionText ) != $this->Text )
       {
           $this->setAttribute( 'text', $http->postVariable( $postQuestionText ) );
       }
 
       $postQuestionMandatoryHidden = $prefix . '_ezsurvey_question_' . $this->ID . '_mandatory_hidden_' . $attributeID;
       if( $http->hasPostVariable( $postQuestionMandatoryHidden ) )
       {
           $postQuestionMandatory = $prefix . '_ezsurvey_question_' . $this->ID . '_mandatory_' . $attributeID;
           if( $http->hasPostVariable( $postQuestionMandatory ) )
               $newMandatory = 1;
           else
               $newMandatory = 0;
 
           if( $newMandatory != $this->Mandatory )
               $this->setAttribute( 'mandatory', $newMandatory );
       }
   }
 
   /*
     * Checks if a captcha has been provided in the case the question is mandatory
     */
   function processViewActions( &$validation, $params )
   {

       $http = eZHTTPTool::instance();
       $variableArray = array();
 
       $prefix = eZSurveyType::PREFIX_ATTRIBUTE;
       $attributeID = $params[ 'contentobjectattribute_id' ];
 
       $postSurveyAnswer = $prefix . '_ezsurvey_answer_' . $this->ID . '_' . $attributeID;

       if ( $this->attribute( 'mandatory' ) == 1 )
       {
            
            $captcha_valid = false;
			
            $pVariable = $postSurveyAnswer;
            $sVariable = 'nxc_captcha_survey_attribute_'.$attributeID;

            if( $http->hasPostVariable( $pVariable ) ) {
                $pCaptcha = strtolower( $http->postVariable( $pVariable ) );
                $sCaptcha = strtolower( $http->sessionVariable( $sVariable ) );

                eZDebug::writeDebug( $sCaptcha, 'Current captcha value' );
                if( strlen( $sCaptcha ) > 0 && $pCaptcha == $sCaptcha ) {
				          $captcha_valid = true;    

                  // Remove session variable!
                  $http->removeSessionVariable( $sVariable );
                }
            }

          /* Failsafe against session variable buildup
          foreach($_SESSION as $sCheckSessionKey => $sKeyValue) {
            // Carefuly check using replaced length change trick (safer than stripos)
            if( strlen( str_ireplace( $sCheckSessionKey, 'nxc_captcha_' ) < strlen( $sCheckSessionKey ) ) )  {
              $http->removeSessionVariable( $sCheckSessionKey );
            }
          }
          */

           if( !$captcha_valid )
           {
               $validation['error'] = true;
               $validation['errors'][] = array( 'message' => ezpI18n::tr( 'survey', 'Please re-enter the captcha value', null,
                                                array( '%number' => $this->questionNumber() ) ),
                                                'question_number' => $this->questionNumber(),
                                                'code' => 'general_answer_number_as_well',
                                                'question' => $this );
               return false;
           }
       }

      //SKIP saving: $this->setAnswer( $http->postVariable( $postSurveyAnswer, '' ) );
      //SKIP saving: $variableArray[ 'answer' ] = $http->postVariable( $postSurveyAnswer, '' );
 
       return $variableArray;
   }
 
   /*
     * called when a user answers a question on the public side
     */
   function answer()
   {
      /* answer is not stored */      
       return false;
   }
}
eZSurveyQuestion::registerQuestionType( ezpI18n::tr( 'survey', 'NXC Captcha' ), 'NXCCaptcha' );
?>