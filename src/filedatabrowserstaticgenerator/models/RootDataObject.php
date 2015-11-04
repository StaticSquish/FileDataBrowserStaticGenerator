<?php


namespace filedatabrowserstaticgenerator\models;

/**
 *  @license 3-clause BSD
 */
class RootDataObject {

  protected $slug;

  protected $title;

  protected $description;

  /**
   * Get the value of Slug
   *
   * @return mixed
   */
  public function getSlug()
  {
      return $this->slug;
  }

  /**
   * Set the value of Slug
   *
   * @param mixed slug
   *
   * @return self
   */
  public function setSlug($slug)
  {
      $this->slug = $slug;

      return $this;
  }

  /**
   * Get the value of Title
   *
   * @return mixed
   */
  public function getTitle()
  {
      return $this->title;
  }

  /**
   * Set the value of Title
   *
   * @param mixed title
   *
   * @return self
   */
  public function setTitle($title)
  {
      $this->title = $title;

      return $this;
  }

  /**
   * Get the value of Description
   *
   * @return mixed
   */
  public function getDescription()
  {
      return $this->description;
  }

  /**
   * Set the value of Description
   *
   * @param mixed description
   *
   * @return self
   */
  public function setDescription($description)
  {
      $this->description = $description;

      return $this;
  }

}
