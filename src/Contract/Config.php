<?php

namespace Xeviant\Paystack\Contract;

interface Config
{
    /**
     * Returns Paystack Public Key.
     *
     * @return string
     */
    public function getPublicKey(): string;

    /**
     * Sets Paystack Public Key.
     *
     * @param $publicKey
     *
     * @return mixed
     */
    public function setPublicKey($publicKey): self;

    /**
     * Returns Paystack Secret Key.
     *
     * @return string
     */
    public function getSecretKey(): string;

    /**
     * Sets Paystack Secret Key.
     *
     * @param $secretKey
     *
     * @return mixed
     */
    public function setSecretKey($secretKey): self;

    /**
     * Returns current package version.
     *
     * @return string
     */
    public function getPackageVersion(): string;

    /**
     * Sets current package version.
     *
     * @param $version
     *
     * @return mixed
     */
    public function setPackageVersion($version): self;

    /**
     * Returns the Paystack API version.
     *
     * @return string
     */
    public function getApiVersion();

    /**
     * Sets the Paystack API version.
     *
     * @param string $apiVersion
     *
     * @return $this
     */
    public function setApiVersion($apiVersion): self;
}
