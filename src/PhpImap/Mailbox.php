<?php

declare(strict_types=1);

namespace S3bul\PhpImap;

use PhpImap\Exceptions\InvalidParameterException;
use PhpImap\Mailbox as BaseMailbox;

/**
 * Class Mailbox
 *
 * @author Sebastian Korzeniecki <seba5zer@gmail.com>
 * @package S3bul\PhpImap
 */
class Mailbox extends BaseMailbox
{
    const SUPPORTED_PARAMS = ['DISABLE_AUTHENTICATOR', 'ssl'];

    /**
     * @inheritdoc
     */
    public function setConnectionArgs(int $options = 0, int $retriesNum = 0, array $params = null): void
    {
        if(0 !== $options) {
            if(($options & self::IMAP_OPTIONS_SUPPORTED_VALUES) !== $options) {
                throw new InvalidParameterException('Please check your option for setConnectionArgs()! Unsupported option "' . $options . '". Available options: https://www.php.net/manual/de/function.imap-open.php');
            }
            $this->imapOptions = $options;
        }

        if(0 != $retriesNum) {
            if($retriesNum < 0) {
                throw new InvalidParameterException('Invalid number of retries provided for setConnectionArgs()! It must be a positive integer. (eg. 1 or 3)');
            }
            $this->imapRetriesNum = $retriesNum;
        }

        if(\is_array($params) && \count($params) > 0) {
            foreach(\array_keys($params) as $key) {
                if(!\in_array($key, self::SUPPORTED_PARAMS, true)) {
                    throw new InvalidParameterException('Invalid array key of params provided for setConnectionArgs()! Only DISABLE_AUTHENTICATOR is currently valid.');
                }
            }

            $this->imapParams = $params;
        }
    }

}
