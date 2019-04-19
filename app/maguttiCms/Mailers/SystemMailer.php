<?php namespace App\maguttiCms\Mailers;

class SystemMailer extends BaseMailer
{
    /**
     * This method is used to setup the necessary settings in order
     * to send a contact request notification to the admins.
     *
     * @param array $data
     *
     * @return \App\maguttiCms\Mailers\SystemMailer
     */
    public function notifyContactFormSubmission($subject, $data = [])
    {
        $this->view = 'emails.contact';
        $this->data = $data;
        $this->subject = $subject;

        return $this;
    }
}