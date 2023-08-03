<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore\Tests\Unit\Asset;

use Micro\Plugin\WebpackEncore\Asset\EntrypointLookup;
use Micro\Plugin\WebpackEncore\Exception\EntrypointNotFoundException;
use Micro\Plugin\WebpackEncore\WebpackEncorePluginConfigurationInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * @covers \Micro\Plugin\WebpackEncore\Asset\EntrypointLookup
 */
class EntrypointLookupTest extends TestCase
{
    public const DECODED_ENTRYPOINTS = [
        'entrypoints' => [
            'entrypoint1' => [
                'js' => [
                    '/some/path/to/jsFile.js',
                    '/another/path/to/js/file.js',
                    '/build/app.js',
                ],
            ],
            'entrypoint2' => [
                'js' => [
                    '/some/path/to/another/js/file.js',
                ],
                'css' => [
                    '/some/path/to/js/file.css',
                ],
            ],
        ],
    ];

    private EntrypointLookup $model;

    private WebpackEncorePluginConfigurationInterface|MockObject $configurationMock;

    private JsonDecode|MockObject $jsonDecodeMock;

    protected function setUp(): void
    {
        $this->configurationMock = $this->getMockBuilder(WebpackEncorePluginConfigurationInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getOutputPath'])
            ->getMockForAbstractClass();

        $this->jsonDecodeMock = $this->getMockBuilder(JsonDecode::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['decode'])
            ->getMock();

        $this->model = new EntrypointLookup($this->configurationMock, $this->jsonDecodeMock);
    }

    /**
     * @dataProvider getCssFilesDataProvider
     *
     * @covers \Micro\Plugin\WebpackEncore\Asset\EntrypointLookup::getCssFiles
     */
    public function testGetCssFiles(
        string $entryName,
        array $expectedResult,
        string $expectedJson,
        ?array $decodedJson
    ): void {
        $this->configurationMock->expects($this->any())
            ->method('getOutputPath')
            ->willReturn(__DIR__.'/../fixtures/correct');

        $this->jsonDecodeMock->expects($this->once())
            ->method('decode')
            ->with($expectedJson)
            ->willReturn($decodedJson);

        $this->assertEquals($expectedResult, $this->model->getCssFiles($entryName));
    }

    public function getCssFilesDataProvider(): array
    {
        return [
            [
                'entryName' => 'entrypoint1',
                'expectedResult' => [],
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
            [
                'entryName' => 'entrypoint2',
                'expectedResult' => [
                    '/some/path/to/js/file.css',
                ],
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
        ];
    }

    /**
     * @dataProvider getJavaScriptFilesDataProvider
     *
     * @covers \Micro\Plugin\WebpackEncore\Asset\EntrypointLookup::getJavaScriptFiles
     */
    public function testGetJavaScriptFiles(
        string $entryName,
        array $expectedResult,
        string $expectedJson,
        ?array $decodedJson
    ): void {
        $this->configurationMock->expects($this->any())
            ->method('getOutputPath')
            ->willReturn(__DIR__.'/../fixtures/correct');

        $this->jsonDecodeMock->expects($this->once())
            ->method('decode')
            ->with($expectedJson)
            ->willReturn($decodedJson);

        $this->assertEquals($expectedResult, $this->model->getJavaScriptFiles($entryName));
    }

    public function getJavaScriptFilesDataProvider(): array
    {
        return [
            [
                'entryName' => 'entrypoint1',
                'expectedResult' => [
                    '/some/path/to/jsFile.js',
                    '/another/path/to/js/file.js',
                    '/build/app.js',
                ],
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
            [
                'entryName' => 'entrypoint2',
                'expectedResult' => [
                    '/some/path/to/another/js/file.js',
                ],
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
        ];
    }

    /**
     * @dataProvider entryExistsDataProvider
     *
     * @covers \Micro\Plugin\WebpackEncore\Asset\EntrypointLookup::entryExists
     */
    public function testEntryExists(
        string $entryName,
        bool $expectedResult,
        string $expectedJson,
        ?array $decodedJson
    ): void {
        $this->configurationMock->expects($this->any())
            ->method('getOutputPath')
            ->willReturn(__DIR__.'/../fixtures/correct');

        $this->jsonDecodeMock->expects($this->once())
            ->method('decode')
            ->with($expectedJson)
            ->willReturn($decodedJson);

        $this->assertEquals($expectedResult, $this->model->entryExists($entryName));
    }

    public function entryExistsDataProvider(): array
    {
        return [
            [
                'entryName' => 'entrypoint1',
                'expectedResult' => true,
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
            [
                'entryName' => 'entrypoint2',
                'expectedResult' => true,
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
            [
                'entryName' => 'entrypoint3',
                'expectedResult' => false,
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
        ];
    }

    /**
     * @dataProvider exceptionsInValidateEntryNameDataProvider
     */
    public function testExceptionsInValidateEntryName(
        string $entryName,
        string $expectedExceptionMessageMatches,
        string $expectedJson,
        ?array $decodedJson
    ): void {
        $this->configurationMock->expects($this->any())
            ->method('getOutputPath')
            ->willReturn(__DIR__.'/../fixtures/correct');

        $this->jsonDecodeMock->expects($this->once())
            ->method('decode')
            ->with($expectedJson)
            ->willReturn($decodedJson);

        $this->expectException(EntrypointNotFoundException::class);
        $this->expectExceptionMessageMatches($expectedExceptionMessageMatches);
        $this->model->getJavaScriptFiles($entryName);
    }

    public function exceptionsInValidateEntryNameDataProvider(): array
    {
        return [
            [
                'entryName' => 'entrypoint1.js',
                'expectedExceptionMessageMatches' => '/Could not find the entry "entrypoint1.js"\. Try "entrypoint1" instead \(without the extension\)\./',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
            [
                'entryName' => 'entrypoint3',
                'expectedExceptionMessageMatches' => '/Could not find the entry "entrypoint3" in ".*". Found: entrypoint1, entrypoint2\./',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
            [
                'entryName' => 'entrypoint4.js',
                'expectedExceptionMessageMatches' => '/Could not find the entry "entrypoint4.js" in ".*". Found: entrypoint1, entrypoint2\./',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/correct/entrypoints.json'),
                'decodedJson' => self::DECODED_ENTRYPOINTS,
            ],
        ];
    }

    /**
     * @dataProvider invalidArgumentExceptionInGetEntriesDataDataProvider
     */
    public function testInvalidArgumentExceptionInGetEntriesData(
        string $entrypointFilePath,
        string $expectedExceptionMessageMatches,
        string $expectedJson,
        ?array $decodedJson
    ): void {
        $this->configurationMock->expects($this->any())
            ->method('getOutputPath')
            ->willReturn(__DIR__.$entrypointFilePath);

        $this->jsonDecodeMock->expects($this->any())
            ->method('decode')
            ->with($expectedJson)
            ->willReturn($decodedJson);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches($expectedExceptionMessageMatches);
        $this->model->entryExists('some-entry-name');
    }

    public function invalidArgumentExceptionInGetEntriesDataDataProvider(): array
    {
        return [
            [
                'entrypointFilePath' => '/../fixtures/bad_json',
                'expectedExceptionMessageMatches' => '/There was a problem JSON decoding the ".*\/fixtures\/bad_json\/entrypoints.json" file\. Try to run npm\/yarn build to fix the issue\./',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/bad_json/entrypoints.json'),
                'decodedJson' => null,
            ],
            [
                'entrypointFilePath' => '/../fixtures/no_entrypoint_key',
                'expectedExceptionMessageMatches' => '/Could not find an "entrypoints" key in the ".*\/fixtures\/no_entrypoint_key\/entrypoints.json" file\. Try to run npm\/yarn build to fix the issue\./',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/no_entrypoint_key/entrypoints.json'),
                'decodedJson' => ['entrypoint' => []],
            ],
            [
                'entrypointFilePath' => '/../fixtures/no_file',
                'expectedExceptionMessageMatches' => '/Could not find the entrypoints file from Webpack: the file ".*\/fixtures\/no_file\/entrypoints.json" does not exist\. Maybe you forgot to run npm\/yarn build?/',
                'expectedJson' => '',
                'decodedJson' => null,
            ],
            [
                'entrypointFilePath' => '/../fixtures/bad_json',
                'expectedExceptionMessageMatches' => '/There was a problem JSON decoding the ".*" file\. Try to run npm\/yarn build to fix the issue\./',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/bad_json/entrypoints.json'),
                'decodedJson' => null,
            ],
        ];
    }

    /**
     * @dataProvider jsonDecoderThrowsExceptionDataProvider
     */
    public function testJsonDecoderThrowsException(
        string $entrypointFilePath,
        string $expectedExceptionMessageMatches,
        string $expectedJson
    ): void {
        $this->configurationMock->expects($this->any())
            ->method('getOutputPath')
            ->willReturn(__DIR__.$entrypointFilePath);

        $exception = new UnexpectedValueException('UnexpectedValueException message');

        $this->jsonDecodeMock->expects($this->any())
            ->method('decode')
            ->with($expectedJson)
            ->willThrowException($exception);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches($expectedExceptionMessageMatches);

        $this->model->entryExists('some-entry-name');
    }

    public function jsonDecoderThrowsExceptionDataProvider(): array
    {
        return [
            [
                'entrypointFilePath' => '/../fixtures/bad_json',
                'expectedExceptionMessageMatches' => '/There was a problem JSON decoding the ".*" file/',
                'expectedJson' => file_get_contents(__DIR__.'/../fixtures/bad_json/entrypoints.json'),
            ],
        ];
    }
}
