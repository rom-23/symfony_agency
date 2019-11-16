<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $lastname;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{10}/")
     */
    private $phone;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Lenght(min=10)
     */
    private $message;

    /**
     *var Property|null
     */
    private $property;


    /**
     * Get the value of Firstname
     *
     * @return mixed
     */
    public function getFirstname()
    {
        return $this -> firstname;
    }

    /**
     * Get the value of Lastname
     *
     * @return mixed
     */
    public function getLastname()
    {
        return $this -> lastname;
    }

    /**
     * Get the value of Phone
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this -> phone;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this -> email;
    }

    /**
     * Get the value of Message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this -> message;
    }


    /**
     * Set the value of Firstname
     *
     * @param mixed $firstname
     *
     * @return self
     */
    public function setFirstname( $firstname )
    {
        $this -> firstname = $firstname;

        return $this;
    }

    /**
     * Set the value of Lastname
     *
     * @param mixed $lastname
     *
     * @return self
     */
    public function setLastname( $lastname )
    {
        $this -> lastname = $lastname;

        return $this;
    }

    /**
     * Set the value of Phone
     *
     * @param mixed $phone
     *
     * @return self
     */
    public function setPhone( $phone )
    {
        $this -> phone = $phone;

        return $this;
    }

    /**
     * Set the value of Email
     *
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail( $email )
    {
        $this -> email = $email;

        return $this;
    }

    /**
     * Set the value of Message
     *
     * @param mixed $message
     *
     * @return self
     */
    public function setMessage( $message )
    {
        $this -> message = $message;

        return $this;
    }


    /**
     * Get the value of var Property|null
     *
     * @return mixed
     */
    public function getProperty()
    {
        return $this -> property;
    }

    /**
     * Set the value of var Property|null
     *
     * @param mixed $property
     *
     * @return self
     */
    public function setProperty( $property )
    {
        $this -> property = $property;

        return $this;
    }
}
