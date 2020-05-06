<?php declare(strict_types=1);

namespace App\Tests\Users\User\Application\DeleteUser;

use App\Users\User\Application\DeleteUser\DeleteUserCommand;
use PHPUnit\Framework\TestCase;

class DeleteUserCommandTest extends TestCase
{
    private const EMAIL = 'test@test.de';

    /**
     * @group UnitTests
     * @group Users
     * @group Application
     */
    public function testDeleteUserCommandCannotBeInstantiatedDirectly()
    {
        self::expectException(\Error::class);

        new DeleteUserCommand();
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Application
     */
    public function testDeleteUserCommandCanBeBuilt()
    {
        $deleteUserCommand = DeleteUserCommand::build(
            self::EMAIL
        );

        self::assertInstanceOf(DeleteUserCommand::class, $deleteUserCommand);
        self::assertEquals(self::EMAIL, $deleteUserCommand->email());
    }
}
