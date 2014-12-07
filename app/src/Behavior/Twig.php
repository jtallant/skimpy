<?php namespace Skimpy\Behavior;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait Twig
{
    /**
     * Renders a view and returns a Response.
     *
     * To stream a view, pass an instance of StreamedResponse as a third argument.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A Response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $twig = $this['twig'];

        if ($response instanceof StreamedResponse) {
            $response->setCallback(function () use ($twig, $view, $parameters) {
                $twig->display($view, $parameters);
            });
            return $response;
        }

        if (null === $response) {
            $response = $this->getCacheableResponse();
        }

        $response->setContent($twig->render($view, $parameters));

        return $response;
    }

    /**
     * Renders a view.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return Response A Response instance
     */
    public function renderView($view, array $parameters = array())
    {
        return $this['twig']->render($view, $parameters);
    }

    protected function getCacheableResponse()
    {
        $response = new Response;

        if ($this->isCachingEnabled() && $this->isCacheableEnv()) {
            $response->setTtl($this['http_cache.default_ttl']);
        }

        return $response;
    }

    protected function isCachingEnabled()
    {
        return $this['http_cache.enabled'];
    }

    protected function isCacheableEnv()
    {
        return 'prod' == $this['env'];
    }
}