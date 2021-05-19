<?php
/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\ImporterMagento1\Application\Factory;

use Ergonode\Importer\Application\Provider\SourceFormFactoryInterface;
use Ergonode\Importer\Domain\Entity\Source\AbstractSource;
use Ergonode\ImporterMagento1\Application\Form\ImporterMagento1ConfigurationForm;
use Ergonode\ImporterMagento1\Application\Model\ImporterMagento1ConfigurationModel;
use Ergonode\ImporterMagento1\Domain\Entity\Magento1CsvSource;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ImporterMagento1SourceFormFactory implements SourceFormFactoryInterface
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function supported(string $type): bool
    {
        return Magento1CsvSource::TYPE === $type;
    }

    /**
     * @param Magento1CsvSource|null $source
     */
    public function create(AbstractSource $source = null): FormInterface
    {
        $model = new ImporterMagento1ConfigurationModel($source);
        if (null === $source) {
            return $this->formFactory->create(ImporterMagento1ConfigurationForm::class, $model);
        }

        return $this->formFactory->create(
            ImporterMagento1ConfigurationForm::class,
            $model,
            ['method' => Request::METHOD_PUT],
        );
    }
}
