<?php
/**
 * @file
 * Contains \Drupal\hello\Form\My.
 */
    namespace Drupal\hello\Form;


    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Core\Form\FormBase;
    use Drupal\Core\Config\ConfigFactoryInterface;
    use Drupal\Core\Config\StateInterface;


   class My extends FormBase {
       /**
        * The state keyvalue collection.
        *
        * @var \Drupal\Core\State\StateInterface
        */
       protected $state;

       /**
        * Constructs a new SiteMaintenanceModeForm.
        *
        * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
        *   The factory for configuration objects.
        * @param \Drupal\Core\State\StateInterface $state
        *   The state keyvalue collection to use.
        */
       public function __construct(ConfigFactoryInterface $config_factory, StateInterface $state) {
           parent::__construct($config_factory);
           $this->state = $state;
       }


       /**
         * {@inheritdoc}
         */
        public function getFormId()
    {
       return 'new_form_My';
    }
         /**
         *  {@inheritdoc}
         */
       public function buildForm(array $form, FormStateInterface $form_state) {
           $form['site_name'] = array(
               '#type' => 'textfield',
               '#title' => t('Site name'),
               '#required' => TRUE,
           );
           $form['slogan_name'] = array(
               '#type' => 'textfield',
               '#title' => t('Site slogan'),
               '#required' => TRUE,
           );
           $form['maintenance_mode'] = array(
               '#type' => 'checkbox',
               '#title' => t('Put site into maintenance mode'),
           );

           $form['submit'] = array(
               '#type' => 'submit',
               '#value' => t('Submit'),
           );
           return $form;
       }

       /**
        * {@inheritdoc}
        */
       public function validateForm(array &$form, FormStateInterface $form_state) {
           if ($form_state->getValues()['site_name'] == \Drupal::config('system.site')->get('name')) {
               $form_state->setErrorByName('site_name', t('Site name must be different from the current one!'));
           }

           }


       /**
        * {@inheritdoc}
        */
       public function submitForm(array &$form, FormStateInterface $form_state)
       {
           \Drupal::configFactory()->getEditable('system.site')->set('name', $form_state->getValues()['site_name'])->save();
           \Drupal::configFactory()->getEditable('system.site')->set('slogan', $form_state->getValue('slogan_name'))->save();
           //\Drupal::state()->set('maintenance_mode',$form_state->getValues()['maintenance_mode']);
           //$this->configFactory->get('system.maintenance')->set('enabled',$form_state->getValues()['maintenance_mode'])->save(;

       }
   }

