<?php

namespace Shaz3e\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use DiligentCreators\LaravelInstaller\Events\LaravelInstallerFinished;
use DiligentCreators\LaravelInstaller\Helpers\EnvironmentManager;
use DiligentCreators\LaravelInstaller\Helpers\FinalInstallManager;
use DiligentCreators\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \DiligentCreators\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \DiligentCreators\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \DiligentCreators\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
