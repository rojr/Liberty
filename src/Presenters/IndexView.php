<?php

namespace Project\Liberty\Presenters;

use Project\Liberty\Models\Contact;
use Rhubarb\Leaf\Presenters\Controls\Buttons\Button;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;
use Rhubarb\Patterns\Mvp\Crud\CrudView;

class IndexView extends CrudView
{

    use WithJqueryViewBridgeTrait;

    public function createPresenters()
    {
        parent::createPresenters();

        $this->addPresenters(
            $name = new TextBox( 'Name' ),
            $email = new TextBox( 'Email' ),
            $website = new TextBox( 'Website' ),
            $company = new TextBox( 'CompanyName' ),
            $send = new Button( 'Send', 'Register', function()
            {
                $contact = new Contact();
                $contact->Name = $this->presenters[ 'Name' ]->Text;
                $contact->ContactEmail = $this->presenters[ 'Email' ]->Text;
                $contact->CompanyName = $this->presenters[ 'CompanyName' ]->Text;
                $contact->Website = $this->presenters[ 'Website' ]->Text;
                $contact->IP = $_SERVER[ 'REMOTE_ADDR' ];
                $contact->save();
            }, true )
        );

        foreach( $this->presenters as $presenter )
        {
            if( $presenter instanceof TextBox )
            {
                $presenter->addHtmlAttribute( 'value', '' );
                $presenter->addCssClassName( 'alert' );
            }
        }

        $name->setPlaceholderText( 'Name' );
        $email->setPlaceholderText( 'Contact Email Address' );
        $website->setPlaceholderText( 'Website (If any)' );
        $company->setPlaceholderText( 'Company Name' );

        $send->addCssClassName( 'c-button c-button--secondary' );
    }

    protected function printViewContent()
    {
        parent::printViewContent();

        ?>
        <div class="c-section js-slideUp">
            <div class="c-section__header">
                <ul class="c-list c-list--inline c-list--nav">
                    <li><a href="#">about liberty</a></li>
                    <li><a href="#">terms of service</a></li>
                    <li><a href="#">get in touch</a></li>
                </ul>
            </div>
            <div class="wrap">
                <div class="u-v">
                    <h1 class="c-title c-title--main animated fadeInUp js-title--main">Giving small business a fighting chance online.</h1>
                    <div class="c-section__text animated fadeInUp js-text--main">
                        <p>We feel that every business deserves to leave their mark on the internet. That’s why we’re giving away <span class="u-white u-b">1 FREE</span> bespoke single page website every <span class="u-white u-b">2 WEEKS</span>.</p>

                        <p>Register below for your chance to win.</p>
                    </div>
                    <a href="#" class="c-button c-button--primary animated fadeInUp js-button--register">Register</a>
                </div>
            </div>
            <div class="c-section__form js-input-overlay alert-error">
                <a href="#"><img src="/static/images/close.png" alt="close" width="35"/></a>
                <?php
                    print "<label>Name</label>";
                    print $this->presenters[ 'Name' ];
                    print "<label>Email</label>";
                    print $this->presenters[ 'Email' ];
                    print "<label>Website</label>";
                    print $this->presenters[ 'Website' ];
                    print "<label>Company Name</label>";
                    print $this->presenters[ 'CompanyName' ];
                    print $this->presenters[ 'Send' ];
                ?>
            </div>
        </div>
        <?php
    }

    public function getDeploymentPackageDirectory()
    {
        return __DIR__;
    }
}