<?php
/**
 * This class extends the core Encrypt class, and allows you
 * to use encrypted strings in your URLs.
 */
class myencrypt 
{
    /**
     * Encodes a string.
     * 
     * @param string $string The string to encrypt.
     * @param string $key[optional] The key to encrypt with.
     * @param bool $url_safe[optional] Specifies whether or not the
     *                returned string should be url-safe.
     * @return string
     */
    function encode($string, $key="", $url_safe=TRUE)
    {
		$CI = & get_instance();
		$CI->load->library('encrypt');
        $ret = $CI->encrypt->encode($string, $key);
        
        if ($url_safe)
        {
            $ret = strtr(
                    $ret,
                    array(
                        '+' => '.',
                        '=' => '-',
                        '/' => '~'
                    )
                );
        }
        
        return $ret;
    }
    
    /**
     * Decodes the given string.
     * 
     * @access public
     * @param string $string The encrypted string to decrypt.
     * @param string $key[optional] The key to use for decryption.
     * @return string
     */
    function decode($string, $key="")
    {
        $string = strtr(
                $string,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            );
         
		$CI = & get_instance();
		$CI->load->library('encrypt');
        return $CI->encrypt->decode($string, $key);
    }
}

// End of file: MY_Encrypt.php
// Location: ./system/application/helpers/MY_Encrypt.php  