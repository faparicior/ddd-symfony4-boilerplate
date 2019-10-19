<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain\Service;

use App\Shared\Domain\Service\UniqueIdProvider;
use Ramsey\Uuid\UuidFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UniqueIdProviderServiceTest extends TestCase
{

    /**
     * @group Shared
     * @group Domain
     * @throws \Exception
     */
    public function testUniqueUuidProvideCanCreateValidUuids()
    {
        $uuid = (new UniqueIdProvider(new UuidFactory()))->generate();

        $regex = "/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/";

        self::assertEquals(1, preg_match($regex, $uuid));
    }
}
