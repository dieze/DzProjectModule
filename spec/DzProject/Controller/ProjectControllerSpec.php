<?php

/**
 * ProjectController specification
 * @author     Adrien Desfourneaux
 * @package    DzProject\Controller
 * @category   Spec
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace spec\DzProject\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du
 * contrôleur de projet ProjectController.
 * 
 */
class ProjectControllerSpec extends ObjectBehavior
{
    /** 
     * Initialisation des spécifications.
     * 
     * @param Zend\Mvc\Controller\PluginManager  $plugins Objet mock de PluginManager.
     * @param Zend\Mvc\Controller\Plugin\Params  $params  Objet mock de Params.
     * @param Zend\ServiceManager\ServiceManager $sl      Objet mock de ServiceManager.
     * @param DzProject\Service\ProjectService   $service Objet mock de ProjectService.
     * @param DzProject\Model\ProjectRepository  $repo    Objet mock de ProjectRepository.
     */
    public function let($plugins, $params, $sl, $service, $repo)
    {
        $this->setPluginManager($plugins);

        $plugins->setController(Argument::any())
                ->willReturn($plugins);

        $plugins->get('params', Argument::cetera())
                ->willReturn($params);

        $this->setServiceLocator($sl);

        $sl->get('dzproject_service')
           ->willReturn($service);
        
        $service->getRepository()
                ->willReturn($repo);
    }

    /**
     * Le ProjectController doit être initialisable.
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Controller\ProjectController');
    }

    /**
     * Le ProjectController doit répondre à
     * l'action index.
     *
     */
    function it_responds_to_index_action()
    {
        $this->indexAction()
             ->shouldReturnAnInstanceOf('Zend\View\Model\ViewModel');
    }

    /**
     * Le ProjectController doit répondre à 
     * l'action showall avec le paramètre de route all.
     *
     * @param Zend\Mvc\Controller\Plugin\Params           $params Objet mock de Params.
     * @param DzProject\Model\ProjectRepository           $repo   Objet mock de ProjectRepository.
     * @param Doctrine\Common\Collections\ArrayCollection $coll   Objet mock de ArrayCollection.
     */
    function it_returns_all_projects_on_showall_action_with_route_parameter_all($params, $repo, $coll)
    {
        $params->fromRoute('type')
               ->shouldBeCalled()
               ->willReturn('all');

        $repo->findAllProjects()
             ->shouldBeCalled()
             ->willReturn($coll);

        // TODO: 
        // check if $this->showAllAction returns exactly
        // an instance of Zend\View\Model\ViewModel
        // with $coll passed as parameter.

        $this->showallAction()
             ->shouldReturnAnInstanceOf('Zend\View\Model\ViewModel');
    }

    /**
     * Le ProjectController doit répondre à 
     * l'action showall avec le paramètre de route active.
     *
     * @param Zend\Mvc\Controller\Plugin\Params           $params Objet mock de Params.
     * @param DzProject\Model\ProjectRepository           $repo   Objet mock de ProjectRepository.
     * @param Doctrine\Common\Collections\ArrayCollection $coll   Objet mock de ArrayCollection.
     */
    function it_returns_all_projects_on_showall_action_with_route_parameter_active($params, $repo, $coll)
    {
        $params->fromRoute('type')
               ->shouldBeCalled()
               ->willReturn('active');

        $repo->findActiveProjects()
             ->shouldBeCalled()
             ->willReturn($coll);
        
        // TODO: 
        // check if $this->showAllAction returns exactly
        // an instance of Zend\View\Model\ViewModel
        // with $coll passed as parameter.

        $this->showallAction()
             ->shouldReturnAnInstanceOf('Zend\View\Model\ViewModel');
    }
}