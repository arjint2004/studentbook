 <?php
/**
*
* @package Icy Phoenix
* @version $Id$
* @copyright (c) 2008 Icy Phoenix
* @license http://opensource.org/licenses/GPL-license.php GNU Public License
*
*/

echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n");
echo('<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb">' . "\n");
echo('<head><title>Files List</title></head>' . "\n");
echo('<body style="font-family:\'Courier New\', \'Trebuchet MS\', Verdana, Tahoma;font-size:12px;">' . "\n");
$root_dir = './';
$exclude_array = array('install');
$source_file = 'install/index.html';
$files_list = create_files_list_full($root_dir, '');
foreach ($files_list as $file_element)
{
    if (is_dir($file_element) && !in_array($file_element, $exclude_array))
    {
        $tmp_paths = array();
        $tmp_paths = explode('/', $file_element);
        $skip_sub_folder = false;
        for ($i = 0; $i < sizeof($tmp_paths); $i++)
        {
            for ($j = 0; $j < sizeof($exclude_array); $j++)
            {
                if ($exclude_array[$j] == $tmp_paths[$i])
                {
                    $skip_sub_folder = true;
                    break;
                }
            }
            if ($skip_sub_folder == true)
            {
                break;
            }
        }
        if ($skip_sub_folder == false)
        {
            @unlink($file_element . '/index.html');
            @copy($source_file, $file_element . '/index.html');
            echo('<b style="color:#800080;">&bull;&nbsp;' . $file_element . '</b><br />' . "\n");
            flush();
        }
    }
}

echo('</body>' . "\n" . '</html>');


// FUNCTIONS

function create_files_list_full($dir, $extensions = '')
{
    $directory = @opendir($dir);
    $files_list = array();

    while (@$file = readdir($directory))
    {
        if (!in_array($file, array('.', '..')))
        {
            $is_dir = (is_dir($dir . '/' . $file)) ? true : false;

            $temp_path = str_replace('//', '/', ($dir . '/' . $file));

            $file_details = get_file_details($temp_path);
            $file_title = $file_details['name'];
            $file_type = strtolower($file_details['ext']);

            $process_file = false;
            if ($extensions == '')
            {
                //$file_exclusions_array = array();
                $file_exclusions_array = array('ace', 'bak', 'bmp', 'css', 'gif', 'hl', 'htc', 'htm', 'html', 'ico', 'jar', 'jpeg', 'jpg', 'js', 'pak', 'png', 'rar', 'sql', 'swf', 'tpl', 'ttf', 'txt', 'wmv', 'zip');
                if (!in_array($file_type, $file_exclusions_array))
                {
                    $process_file = true;
                }
            }
            else
            {
                if ( $file_type == $extensions)
                {
                    $process_file = true;
                }
            }

            if ($process_file == true)
            {
                $files_list[] = $temp_path;
            }

            // Directory found, so recall this function
            if ($is_dir)
            {
                $files_list = array_merge($files_list, create_files_list_full($dir . '/' . $file, $extensions));
            }
        } // if
    } // while

    @closedir($directory);

    return $files_list;
}

/*
* get_file_details
* Get File Details: name, extension
*/
function get_file_details($file_name)
{
    $file_details = array();
    $file_tmp = str_replace ('http://', '', $file_name);
    $file_path[] = array();
    $file_path = explode('/', $file_tmp);
    $file_details['name_full'] = $file_path[sizeof($file_path) - 1];
    $file_part = explode('.', strtolower($file_details['name_full']));
    $file_details['ext'] = $file_part[sizeof($file_part) - 1];
    $file_details['name'] = substr($file_details['name_full'], 0, strlen($file_details['name_full']) - strlen($file_details['ext']) - 1);
    return $file_details;
}

?> 