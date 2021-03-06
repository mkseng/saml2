<?php

declare(strict_types=1);

namespace SAML2\Assertion\Validation\ConstraintValidator;

use SAML2\Assertion\Validation\Result;
use SAML2\Assertion\Validation\SubjectConfirmationConstraintValidator;
use SAML2\Utilities\Temporal;
use SAML2\XML\saml\SubjectConfirmation;
use Webmozart\Assert\Assert;

class SubjectConfirmationNotOnOrAfter implements
    SubjectConfirmationConstraintValidator
{
    /**
     * @param \SAML2\XML\saml\SubjectConfirmation $subjectConfirmation
     * @param \SAML2\Assertion\Validation\Result $result
     * @return void
     *
     * @throws \InvalidArgumentException if assertions are false
     */
    public function validate(
        SubjectConfirmation $subjectConfirmation,
        Result $result
    ): void {
        $data = $subjectConfirmation->getSubjectConfirmationData();
        Assert::notNull($data);

        /** @psalm-suppress PossiblyNullReference */
        $notOnOrAfter = $data->getNotOnOrAfter();
        if ($notOnOrAfter && $notOnOrAfter <= Temporal::getTime() - 60) {
            $result->addError('NotOnOrAfter in SubjectConfirmationData is in the past');
        }
    }
}
