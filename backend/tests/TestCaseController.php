<?php


class TestCaseController extends TestCase
{

    protected $baseUrl = 'http://app.dev';

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Sobrecarga do método call possibilitando a chamada
     * dos métodos na seguinte forma $this->get( ... )
     * @param $method
     * @param $args
     * @return \Illuminate\Http\Response
     */
    public function __call($method, $args)
    {
        if (in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            return $this->call($method, $args[0]);
        }

        throw new BadMethodCallException;
    }

}