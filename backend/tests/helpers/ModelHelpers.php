<?php

trait ModelHelpers
{
    use \Way\Tests\ModelHelpers;

    public function assertRelationship($relationship, $class, $type)
    {
        $this->assertRespondsTo($relationship, $class);

        $args = $this->getArgumentsRelationship($relationship, $class, $type);

        $class = Mockery::mock($class."[$type]");

        switch(count($args))
        {
            case 1 :
                $class->shouldReceive($type)
                    ->once()
                    ->with('/' . str_singular($relationship) . '/i');
                break;
            case 2 :
                $class->shouldReceive($type)
                    ->once()
                    ->with('/' . str_singular($relationship) . '/i', $args[1]);
                break;
            case 3 :
                $class->shouldReceive($type)
                    ->once()
                    ->with('/' . str_singular($relationship) . '/i', $args[1], $args[2]);
                break;
            case 4 :
                $class->shouldReceive($type)
                    ->once()
                    ->with($args[0], $args[1], $args[2], $args[3]);
                break;
            default :
                $class->shouldReceive($type)
                    ->once();
                break;
        }

        $class->$relationship();
    }

}