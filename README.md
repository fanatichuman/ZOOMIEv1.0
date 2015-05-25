# ZOOMIEv1.0

5/25/2015

ZOOMIE v 1.0 (Zooplankton Multiple Image Exclusion)

Moritz S. Schmid*, Cyril Aubry, Jordan Grigor, Louis Fortier

Takuvik Joint International Laboratory, Laval University (Canada) – CNRS (France), UMI3376, Département de biologie et Québec-Océan, Université Laval, Québec, Québec G1V 0A6, Canada

* Moritz.Schmid@takuvik.ulaval.ca

Initial set up by Nicolas Garneau, ULaval (paid basis).

See file: ZOOMIE- Introduction v 1.0.docx for full introduction


1. Introduction

ZOOMIE is an image treatment tool developed to ensure optimal quality for images collected with the Lightframe On-sight Keyspecies Investigation (LOKI) System, an underwater zooplankton camera system. ZOOMIE does that by identifying cases where multiple pictures of the same specimen have been taken (hereafter referred to as double images), a phenomenon that frequently occurs when imaging plankton in a constrained volume during vertical deployments. The process of identifying double pictures can be carried out manually but is very time consuming. By applying ZOOMIE, the time needed to identify double images is substantially reduced. It is essential to account for double images when representative distributions of images are wanted
ZOOMIE can automatically filter thousands of images based on previously extracted image parameters (e.g. area, mean grey pixel value, kurtosis; here extracted using the LOKI browser software (Isitec GmbH; http://www.isitec.de/start.htm)). The filtering is based on a set of rules that compares the image parameters of multiple images in order to detect double images and exclude them. The set of rules can be changed easily in the ZOOMIE scripts so that researchers can easily adapt the thresholds for finding double images necessary for their LOKI settings. After running the actual script to find double images, other scripts can be executed to automatically transfer images flagged for exclusion to a new folder.
Finally, the results can be visualized on an internal homepage, using the actual images which are linked to the database. Here we can validate the outcome of the processing and we can manually adapt the outcome through dragging and dropping of images to verify if any images were wrongly allocated to a double image group.
Although ZOOMIE was developed for LOKI images and the exclusion of double images, ZOOMIE could easily be adapted to handle other tasks requiring the handling and comparison of large numbers of images.

