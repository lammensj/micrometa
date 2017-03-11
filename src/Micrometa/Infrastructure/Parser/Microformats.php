<?php

/**
 * micrometa
 *
 * @category Jkphl
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Infrastructure\Parser
 * @author Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright Copyright © 2017 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

/***********************************************************************************
 *  The MIT License (MIT)
 *
 *  Copyright © 2017 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of
 *  this software and associated documentation files (the "Software"), to deal in
 *  the Software without restriction, including without limitation the rights to
 *  use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 *  the Software, and to permit persons to whom the Software is furnished to do so,
 *  subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 *  COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 *  IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 *  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 ***********************************************************************************/

namespace Jkphl\Micrometa\Infrastructure\Parser;

use Jkphl\Micrometa\Application\Contract\ParsingResultInterface;
use Jkphl\Micrometa\Infrastructure\Factory\MicroformatsFactory;
use Psr\Http\Message\UriInterface;

/**
 * Microformats parsere
 *
 * @package Jkphl\Micrometa
 * @subpackage Jkphl\Micrometa\Infrastructure
 */
class Microformats extends AbstractParser
{
    /**
     * Format
     *
     * @var int
     */
    const FORMAT = 1;

    /**
     * RdfaLite constructor
     *
     * @param UriInterface $uri
     */
    public function __construct(UriInterface $uri)
    {
        parent::__construct($uri);
    }

    /**
     * Parse a DOM document
     *
     * @param \DOMDocument $dom DOM Document
     * @return ParsingResultInterface Micro information items
     */
    public function parseDom(\DOMDocument $dom)
    {
        $microformats = \Mf2\parse($dom, strval($this->uri), false);
        $items = isset($microformats['items']) ?
            MicroformatsFactory::createFromParserResult($microformats['items']) : [];
        unset($microformats['items']);
        return new ParsingResult(self::FORMAT, $items, $microformats);
    }
}
