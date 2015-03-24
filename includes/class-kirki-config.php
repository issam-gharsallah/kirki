<?php

class Kirki_Config {

    /** @var array The configuration values for Kirki */
    private $config = null;

    /**
     * Constructor
     */
    public function __construct() {
    }

    /**
     * Get a configuration value
     *
     * @param string $key     The configuration key we are interested in
     * @param string $default The default value if that configuration is not set
     *
     * @return mixed
     */
    public function get($key, $default='') {
        $cfg = $this->get_all();
        return isset($cfg[$key]) ? $cfg[$key] : $default;
    }

    /**
     * Get a configuration value or throw an exception if that value is mandatory
     *
     * @param string $key     The configuration key we are interested in
     *
     * @return mixed
     */
    public function getOrThrow($key) {
        $cfg = $this->get_all();
        if (isset($cfg[$key])) {
            return $cfg[$key];
        }
        throw new RuntimeException(sprintf("Configuration key %s is mandatory and has not been specified", $key));
    }

    /**
     * Get the configuration options for the Kirki customizer.
     *
     * @uses 'kirki/config' filter.
     */
    protected function get_all() {
        if ($this->config==null) {
            // Get configuration from the filter
            $this->config = apply_filters('kirki/config', array());

            // Merge a default configuration with the one we got from the user to make sure nothing is missing
            $default_config = array(
                'stylesheet_id' => 'kirki-styles'
            );
            $this->config = array_merge($default_config, $this->config);
        }

        return $this->config;
    }
}
