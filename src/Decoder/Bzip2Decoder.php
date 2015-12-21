<?php

/*
 * This file is part of the brainbits transcoder package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\Transcoder\Decoder;

use Brainbits\Transcoder\Exception\DecodeFailedException;

/**
 * Bzip2 decoder
 *
 * @author Gregor Welters <gwelters@brainbits.net>
 */
class Bzip2Decoder implements DecoderInterface
{
    const TYPE = 'bzip2';

    /**
     * @inheritDoc
     */
    public function decode($data)
    {
        $data = bzdecompress($data);

        if ($this->isErrorCode($data)) {
            throw new DecodeFailedException("bzdecompress failed.");
        }

        if (!$data) {
            throw new DecodeFailedException("bzdecompress returned no data.");
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supports($type)
    {
        return self::TYPE === $type;
    }

    /**
     * @param mixed $result
     *
     * @return bool
     */
    private function isErrorCode($result)
    {
        return $result === -1 || $result === -2 || $result === -3 || $result === -5 || $result === -6 ||
            $result === -7 || $result === -8 || $result === -9;
    }
}
