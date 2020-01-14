<?php
namespace App\Services;

class MessageService
{

    public function contactFormIsValid($form) {
        $isValid = true;

        if (!array_key_exists('firstName', $form)
        || strlen($form['firstName']) < 1) {
            $isValid = false;
        }

        if (!array_key_exists('lastName', $form)
            || strlen($form['lastName']) < 1) {
            $isValid = false;
        }

        if (!array_key_exists('email', $form)
            || strlen($form['email']) < 1) {
            $isValid = false;
        }

        if (!array_key_exists('message', $form)
            || strlen($form['message']) < 5) {
            $isValid = false;
        }

        return $isValid;
    }

}