elliRPC (PHP-Library)
=====================
<small>provided by [Ellinaut](https://github.com/Ellinaut) </small>

---

## Table of Contents

1. Introduction
2. Installation
3. Register Definitions
4. Register Processors
5. Register Transaction Listeners
6. Register Validators
7. Register Error Factories
8. Register Error Translators
9. Configure File Handling
10. Handle Requests

## Introduction

## Installation

You can install this library via composer:

```bash
composer req ellinaut/ellirpc
```

The library requires request and response objects implementing the PSR-7 (HTTP Message) standard and for this it makes
use of the PSR-17 (HTTP Factories) standard. Therefor you need to install any implementation providing these objects.

We recommend the usage of `nyholm/psr7` which provides PSR-7 and PSR-17 implementations:

```bash
composer req ellinaut/ellirpc nyholm/psr7
```

If you want to use the provided default file system and content type guesser you also have to install the symfony
components "symfony/filesystem" and "symfony/mime":

```bash
composer req symfony/filesystem symfony/mime
```

## Register Definitions

To provide definitions to the definition handler, you need to provide implementations
of `PackageDefinitionLoaderInterface`, `ProcedureDefinitionLoaderInterface` and `SchemaDefinitionLoaderInterface`.

The default implementation of these interfaces is `ArrayDefinitionLoader`, but you could also provide your own
implementation.
Definition arrays for each package can be registered via "registerPackage" method:

```php

$definitionLoader = new \Ellinaut\ElliRPC\Definition\Loader\ArrayDefinitionLoader();

$definitionLoader->registerPackage([
    'name' => 'Test',
    'description' => 'Test package to demonstrate configuration.',
    'procedures' => [],
    'schemas' => [],
    'errors' => []
]);

```

## Register Processors

To execute procedures each procedure requires a procedure processor, which implements `ProcedureProcessorInterface`.

Within the procedure processor the execution of a normal request or a transaction can be figured out by the execution
context which could be `ExecutionContext::STANDALONE` or `ExecutionContext::TRANSACTION`.

If your application has only one procedure processor, it can be passed directly to the RPC handler.
Otherwise, you have to register your processors to a registry and pass this registry to the handler.

The default registry implementation is `ProcedureProcessorRegistry` where processors are added by calling the "register"
method:

```php
$processorRegistry = new \Ellinaut\ElliRPC\Procedure\Processor\ProcedureProcessorRegistry();

$processorRegistry->register(
    'Test', // package name
    'test', // procedure name
    new TestProcessor() // procedure processor for test procedure in Test package
);
```

## Register Transaction Listeners

In some cases transactions may be required to guarantee that all procedures results together or none of them are
executed successfully. Mostly this is coupled to data storage. To guarantee that data could only be stored together for
all executed procedures, the transaction manager is used.

The transaction manager indicates the start, the expected end and breaks of the transaction in case of errors.
Your application can listen to these changes through transaction listeners.

A transaction listener is a php class which implement `TransactionListenerInterface`. Depending on your implementation
your procedure processors or any other class could implement this interface and could be registered as listener to the
manager.

```php
$transactionManager = new \Ellinaut\ElliRPC\Procedure\Transaction\TransactionManager();

$transactionManager->registerListener(
    new CustomTransactionListener()
);
```

## Register Validators

The task of a procedure validator is to validate the transmitted data structure within the procedure call and, if
necessary, to validate the transmitted values in order to be able to detect errors before the actual processing and thus
not to start the execution of a procedure with invalid data.

Your custom validators have to implement `ProcedureValidatorInterface` and should be added to an instance
of `ProcedureValidatorChain` which can be given to the concrete http handler.

On validation error a `ProcedureValidationException` should be thrown.

```php
$procedureValidator = new \Ellinaut\ElliRPC\Procedure\Validator\ProcedureValidatorChain();

$procedureValidator->register(
    new CustomValidator()
);

// validator for specific context (standalone/no transaction in this example)
$procedureValidator->register(
    new CustomValidator(),
    \Ellinaut\ElliRPC\Procedure\Validator\ValidatorContext::STANDALONE
);
```

## Register Error Factories

The task of an error factory is to create an error object out of a php throwable.

Therefor you need to implement factories which have to be classes implementing `ErrorFactoryInterface`.

Your factory may create instances of `Error`, `TranslateableError` or `TranslateableHttpError` or they create custom
error instances which have to extend `Error` and may be implementing `HttpErrorInterface`.

```php
$errorFactory = new \Ellinaut\ElliRPC\Error\Factory\ErrorFactoryChain();

$errorFactory->register(
    new CustomErrorFactory()
);
```

## Register Error Translators

The task of an error translator is to translate the description text of an error message (usually english) into other
languages used by your application to display the error to a user.

Therefor you need to implement translators which have to be classes implementing `ErrorTranslatorInterface`.

All you translators should be added to an instance of `ErrorTranslatorChain` which then can be given to the concrete
http handlers.

```php
$errorTranslator = new \Ellinaut\ElliRPC\Error\Translator\ErrorTranslatorChain();

$errorTranslator->register(
    new CustomErrorTranslator()
);
```

## Configure File Handling

@todo description

```php
$contentTypeGuesser = new \Ellinaut\ElliRPC\File\Bridge\SymfonyContentTypeGuesser(
    new \Symfony\Component\Mime\FileinfoMimeTypeGuesser()
);

// with symfony filesystem and without custom fiel logic use: 
$fallbackFilesystem = new \Ellinaut\ElliRPC\File\Bridge\SymfonyFilesystem(
    new \Symfony\Component\Filesystem\Filesystem()
);
// to disable file uploads use `\Ellinaut\ElliRPC\File\UnsupportedFilesystem` instead!

$filesystem = new \Ellinaut\ElliRPC\File\FilesystemChain($fallbackFilesystem);
// use "filesystem->add" to add custom filesystems which have to implement `\Ellinaut\ElliRPC\File\ChainableFilesystem`

$fallbackFileLocator = new \Ellinaut\ElliRPC\File\LocalBasePathFileLocator(
    __DIR__.'/../files' // local file storage path
);
// to use the same values for public and storage paths and disable resolving use `\Ellinaut\ElliRPC\File\UnresolvedFileLocator` instead!

$fileLocator = new \Ellinaut\ElliRPC\File\FileLocatorChain($fallbackFileLocator);
// use "$fileLocator->add" to add custom file locators which have to implement `\Ellinaut\ElliRPC\File\ChainableFileLocator`
```

## Handle Requests

The main task of the library is to process http requests and generate http responses. These tasks are executed by
handlers.

There are three different handlers. One for documentation purposes (`DefinitionHandler`), one for executing
procedures (`RPCHandler`) and one to work with files (`FileHandler`).

Depending on the need of your application you can use all of these handlers or replace one or more of these handlers
with custom logic which might match better with your application or the used framework.

There is a single php method for every endpoint defined by the api specification.
Your application has to decide which handler and which method have to be called, so it is possible to use own routing
without any dependencies.

The following example shows a full working implementation without any framework dependency. All given parameters which
are not defined directly in this snippet have already been defined in the previous examples of this documentation:

```php
// initialize the factory (in this case with nyholm/psr7 installed)
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

// create a request object which can be handled by the library
$nyholmCreator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $nyholmCreator->fromGlobals();            

if(substr($request->getUri()->getPath(), 0, 12) === '/definitions' && $request->getMethod() === 'GET'){            
    // creating the definition handler
    $definitionHandler = new \Ellinaut\ElliRPC\DefinitionHandler(
        $psr17Factory,
        $psr17Factory,
        $errorFactory,
        $errorTranslator,
        $definitionLoader,
        'Example Application', // application name
        'Example application contains a test package with test procedure' // description
    );
    
    if($request->getUri()->getPath() === ' /definitions'){
        $response = $definitionHandler->executeGetDocumentation($request);
    }
    
    if(substr($request->getUri()->getPath(), 0, 13) === '/definitions/'){
        $response = $definitionHandler->executeGetPackageDefinition($request);
    }
}

if(substr($request->getUri()->getPath(), 0, 12) === '/procedures/' && $request->getMethod() === 'POST'){
    // creating the rpc handler
    $rpcHandler=  new \Ellinaut\ElliRPC\RPCHandler(
        $psr17Factory,
        $psr17Factory,
        $errorFactory,
        $errorTranslator,
        $procedureValidator,
        $procedureProcessorRegistry,
        $transactionManager
    );
    
    if($request->getUri()->getPath() === ' /procedures/execute'){
        $response = $rpcHandler->executeExecuteProcedure($request);
    }
    
    if($request->getUri()->getPath() === ' /procedures/bulk'){
        $response = $rpcHandler->executeExecuteBulk($request);
    }
    
    if($request->getUri()->getPath() === ' /procedures/transaction'){
        $response = $rpcHandler->executeExecuteTransaction($request);
    }
}

if(substr($request->getUri()->getPath(), 0, 6) === '/files'){
    // creating the file handler
    $fileHandler = new \Ellinaut\ElliRPC\FileHandler(
        $psr17Factory,
        $psr17Factory,
        $errorFactory,
        $errorTranslator,
        $fileLocator,
        $filesystem,
        $contentTypeGuesser
    );

    switch ($request->getMethod()){
        case 'GET':
            $response = $fileHandler->executeGetFile($request);
            break;
        case 'POST':
        case 'PUT':
            $response = $fileHandler->executeUploadFile($request);
            break;
        case 'DELETE':
            $response = $fileHandler->executeDeleteFile($request);
            break;
    }
}

// your application has to send $response to client...
```

---
<small>Ellinaut is powered by [NXI GmbH & Co. KG](https://nxiglobal.com)
and [BVH Bootsvermietung Hamburg GmbH](https://www.bootszentrum-hamburg.de).</small>
