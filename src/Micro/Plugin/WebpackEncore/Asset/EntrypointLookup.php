<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore\Asset;

use Micro\Plugin\WebpackEncore\Exception\EntrypointNotFoundException;
use Micro\Plugin\WebpackEncore\WebpackEncorePluginConfigurationInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

class EntrypointLookup implements EntrypointLookupInterface
{
    private ?array $entriesData = null;

    private array $returnedFiles = [];

    public function __construct(
        private readonly WebpackEncorePluginConfigurationInterface $configuration,
        private readonly DecoderInterface $decoder
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getJavaScriptFiles(string $entryName): array
    {
        return $this->getEntryFiles($entryName, 'js');
    }

    /**
     * {@inheritdoc}
     */
    public function getCssFiles(string $entryName): array
    {
        return $this->getEntryFiles($entryName, 'css');
    }

    public function entryExists(string $entryName): bool
    {
        $entriesData = $this->getEntriesData();

        return isset($entriesData['entrypoints'][$entryName]);
    }

    /**
     * @psalm-return array<string>
     */
    private function getEntryFiles(string $entryName, string $key): array
    {
        $this->validateEntryName($entryName);
        $entriesData = $this->getEntriesData();
        /** @var array $entryData */
        $entryData = $entriesData['entrypoints'][$entryName] ?? [];

        if (!isset($entryData[$key])) {
            // If we don't find the file type then just send back nothing.
            return [];
        }

        // make sure to not return the same file multiple times
        /** @var array $entryFiles */
        $entryFiles = $entryData[$key];
        $newFiles = array_values(array_diff($entryFiles, $this->returnedFiles));
        $this->returnedFiles = array_merge($this->returnedFiles, $newFiles);

        return $newFiles;
    }

    private function validateEntryName(string $entryName): void
    {
        /** @var array<string, array> $entriesData */
        $entriesData = $this->getEntriesData();
        if (isset($entriesData['entrypoints'][$entryName])) {
            return;
        }

        if (false === $dotPos = strrpos($entryName, '.')) {
            throw new EntrypointNotFoundException(sprintf('Could not find the entry "%s" in "%s". Found: %s.', $entryName, $this->getEntrypointJsonPath(), implode(', ', array_keys($entriesData['entrypoints']))));
        }

        if (isset($entriesData['entrypoints'][$withoutExtension = substr($entryName, 0, $dotPos)])) {
            throw new EntrypointNotFoundException(sprintf('Could not find the entry "%s". Try "%s" instead (without the extension).', $entryName, $withoutExtension));
        }

        throw new EntrypointNotFoundException(sprintf('Could not find the entry "%s" in "%s". Found: %s.', $entryName, $this->getEntrypointJsonPath(), implode(', ', array_keys($entriesData['entrypoints']))));
    }

    private function getEntriesData(): array
    {
        if (null !== $this->entriesData) {
            return $this->entriesData;
        }

        if (!file_exists($this->getEntrypointJsonPath())) {
            throw new \InvalidArgumentException(sprintf('Could not find the entrypoints file from Webpack: the file "%s" does not exist. Maybe you forgot to run npm/yarn build?', $this->getEntrypointJsonPath()));
        }

        try {
            $entriesData = $this->decoder->decode(file_get_contents($this->getEntrypointJsonPath()), JsonEncoder::FORMAT);
        } catch (UnexpectedValueException $e) {
            throw new \InvalidArgumentException(sprintf('There was a problem JSON decoding the "%s" file. Try to run npm/yarn build to fix the issue.', $this->getEntrypointJsonPath()), 0, $e);
        }

        if (!\is_array($entriesData)) {
            throw new \InvalidArgumentException(sprintf('There was a problem JSON decoding the "%s" file. Try to run npm/yarn build to fix the issue.', $this->getEntrypointJsonPath()));
        }

        if (!isset($entriesData['entrypoints'])) {
            throw new \InvalidArgumentException(sprintf('Could not find an "entrypoints" key in the "%s" file. Try to run npm/yarn build to fix the issue.', $this->getEntrypointJsonPath()));
        }

        return $this->entriesData = $entriesData;
    }

    private function getEntrypointJsonPath(): string
    {
        return $this->configuration->getOutputPath().'/entrypoints.json';
    }
}
