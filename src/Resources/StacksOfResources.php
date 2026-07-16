<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Resources;

use Ekvedaras\SpaceSim\Cost\Cost;
use Ekvedaras\SpaceSim\Cost\MultipleResources;
use Ekvedaras\SpaceSim\Cost\Resources;

use PhpParser\Node\Expr\AssignOp\Mul;

use RuntimeException;

use function Laravel\Prompts\table;

final readonly class StacksOfResources
{
    public function __construct(
        /** @var Stack<Resource::Black> */
        private(set) Stack $blackStack = new Stack(Resource::Black),
        /** @var Stack<Resource::White> */
        private(set) Stack $whiteStack = new Stack(Resource::White),
        /** @var Stack<Resource::Red> */
        private(set) Stack $redStack = new Stack(Resource::Red),
        /** @var Stack<Resource::Blue> */
        private(set) Stack $blueStack = new Stack(Resource::Blue),
        /** @var Stack<Resource::Green> */
        private(set) Stack $greenStack = new Stack(Resource::Green),
        /** @var Stack<Resource::Yellow> */
        private(set) Stack $yellowStack = new Stack(Resource::Yellow),
    ) {
    }

    public function add(Stack $stack): self
    {
        (match ($stack->of) {
            Resource::Black => $this->blackStack,
            Resource::White => $this->whiteStack,
            Resource::Red => $this->redStack,
            Resource::Blue => $this->blueStack,
            Resource::Green => $this->greenStack,
            Resource::Yellow => $this->yellowStack,
        })->add($stack);

        return $this;
    }

    public function print(): void
    {
        table([
                  [
                      $this->blackStack->toCliString(),
                      $this->whiteStack->toCliString(),
                      $this->redStack->toCliString(),
                      $this->blueStack->toCliString(),
                      $this->greenStack->toCliString(),
                      $this->yellowStack->toCliString(),
                  ],
              ]);
    }

    public function hasEnough(Cost $cost): bool
    {
        if ($cost instanceof Resources) {
            return (match ($cost->of) {
                    Resource::Black => $this->blackStack,
                    Resource::White => $this->whiteStack,
                    Resource::Red => $this->redStack,
                    Resource::Blue => $this->blueStack,
                    Resource::Green => $this->greenStack,
                    Resource::Yellow => $this->yellowStack,
            })->amount >= $cost->amount;
        }

        if ($cost instanceof MultipleResources) {
            foreach ($cost->resources as $resources) {
                if (! $this->hasEnough($resources)) {
                    return false;
                }
            }

            return true;
        }

        throw new RuntimeException('Unsupported Cost Type');
    }
}
