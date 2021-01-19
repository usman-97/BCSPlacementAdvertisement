<?php
class ReCaptcha {

    private $uppercaseLetters, $lowercaseLetters, $numbers, $reCaptcha;

    /*
     * ReCaptcha constructor which generates array of
     * characters for reCaptcha
     */
    public function __construct()
    {

        // Array which stores uppercase alphabets A to Z
        $this->uppercaseLetters = range(chr(65), chr(90));
        // Array which stores lowercase alphabets a to z
        $this->lowercaseLetters = range(chr(97), chr(122));
        // Array Which stores numbers 0 to 9
        $this->numbers = range(chr(48), chr(57));
        // All three above array use chr function to get specific character
        // then range function is used to set a range to get specific characters

        // All three above arrays are merged together into one array
        $this->reCaptcha = array_merge($this->uppercaseLetters, $this->lowercaseLetters, $this->numbers);
    }

    /*
     *
     */
    public function generateReCaptcha()
    {
        // Length of reCaptcha
        $length = rand(5, 8);

        // Stores final reCaptcha which will be used for anti spamming
        $finalReCaptcha = '';
        for ($i = 0; $i < $length; $i++)
        {
            $finalReCaptcha .= $this->reCaptcha[array_rand($this->reCaptcha)];
        }
        return  $finalReCaptcha;

    }
}
