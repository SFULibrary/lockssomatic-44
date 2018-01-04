<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * Plugin
 *
 * @ORM\Table(name="plugin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PluginRepository")
 */
class Plugin extends AbstractEntity {

    /**
     * Name of the plugin.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * Path, in the local file system, to the plugin file (includes version number).
     *
     * @var string
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * Original file name for the plugin, does not include the version number.
     *
     * @var string
     * @ORM\Column(name="filename", type="string", length=127)
     */
    private $filename;

    /**
     * Version number for the plugin, from the plugin's Xml config.
     *
     * @var int
     * @ORM\Column(name="version", type="integer")
     */
    private $version;

    /**
     * Plugin identifier (an FQDN) from the plugin's Xml config.
     *
     * @var string
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $identifier;

    /**
     * AUs created for this plugin.
     *
     * @ORM\OneToMany(targetEntity="Au", mappedBy="plugin")
     *
     * @var Au[]|Collection
     */
    private $aus;

    /**
     * Content owners which use the plugin.
     *
     * @ORM\OneToMany(targetEntity="ContentProvider", mappedBy="plugin")
     *
     * @var ContentOwner[]|Collection
     */
    private $contentProviders;

    /**
     * Properties for the plugin.
     *
     * @ORM\OneToMany(targetEntity="PluginProperty", mappedBy="plugin")
     *
     * @var PluginProperty[]|Collection
     */
    private $pluginProperties;

    public function __toString() {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Plugin
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Plugin
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Plugin
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Plugin
     */
    public function setVersion($version) {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Plugin
     */
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * Add aus
     *
     * @param Au $aus
     *
     * @return Plugin
     */
    public function addAus(Au $aus) {
        $this->aus[] = $aus;

        return $this;
    }

    /**
     * Remove aus
     *
     * @param Au $aus
     */
    public function removeAus(Au $aus) {
        $this->aus->removeElement($aus);
    }

    /**
     * Get aus
     *
     * @return Collection
     */
    public function getAus() {
        return $this->aus;
    }

    /**
     * Add contentProvider
     *
     * @param ContentProvider $contentProvider
     *
     * @return Plugin
     */
    public function addContentProvider(ContentProvider $contentProvider) {
        $this->contentProviders[] = $contentProvider;

        return $this;
    }

    /**
     * Remove contentProvider
     *
     * @param ContentProvider $contentProvider
     */
    public function removeContentProvider(ContentProvider $contentProvider) {
        $this->contentProviders->removeElement($contentProvider);
    }

    /**
     * Get contentProviders
     *
     * @return Collection
     */
    public function getContentProviders() {
        return $this->contentProviders;
    }

    /**
     * Add pluginProperty
     *
     * @param PluginProperty $pluginProperty
     *
     * @return Plugin
     */
    public function addPluginProperty(PluginProperty $pluginProperty) {
        $this->pluginProperties[] = $pluginProperty;

        return $this;
    }

    /**
     * Remove pluginProperty
     *
     * @param PluginProperty $pluginProperty
     */
    public function removePluginProperty(PluginProperty $pluginProperty) {
        $this->pluginProperties->removeElement($pluginProperty);
    }

    /**
     * Get pluginProperties
     *
     * @return Collection
     */
    public function getPluginProperties() {
        return $this->pluginProperties;
    }

}