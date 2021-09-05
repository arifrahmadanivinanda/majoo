<?php
declare (strict_types=1);

namespace App\Responder;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Responder Handler
 * @author  pkahfi <pkahfi@dwebsite.net>
 */
class ResponderHandler implements ResponderInterface
{
    private $code;
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function response($data, $code = null)
    {
        if (!null == $code) $this->code = $code;

        $content = $this->twig->render(
            $data,
            $this->code
        );

        return new Response($content);
    }
}
