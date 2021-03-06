# 3 Final Report and Code
Title: Estimating the nutritional status of nitrogen <br />
Student: Adriano Aparecido Virgílio - nº usp: 9877082 <br />

Main objective:
To develop software capable of estimating nitrogen concentration in Brachiaria decumbens cv. Basilisk from the analysis of diagnostic leaf images and thus define the N status of the crop and to evaluate the correlation between vegetation indices, based on RGB obtained from digital images, and the nitrogen concentration in diagnostic leaves of Brachiaria decumbens cv. Basilisk.

Nitrogen is one of the macronutrients essential to the development of the plant, which limits the productivity of pastures in tropical environments. Knowing how much the plant requires of N is an important factor when considering its growth and development. 
The possibility of adopting a tool in which the farmer can identify the nutritional status of the forage in the field, and thus make decisions regarding possible interventions and adjustments in the management of fertilization, is a plausible reality.

Indices of vegetation (VI) based on RGB and obtained from the analysis of digital images can be used to determine the nitrogen status in Brachiaria decumbens cv. Basilisk. For this purpose, the vegetation index used as the basis for image processing by the software should be highly correlated with the nitrogen concentration in the plant, determined by the analytical method. A vegetation index can demonstrate plant health through the result of calculations made from spectral information from different bands of visible light reflected by that plant.

Methodology for obtaining the RGB of the images:
The images with white background obtained in the field were submitted to the prototype of the software developed in PHP language, using the GD and ImageMagick library. The mean values of the red (R), green (G) and blue (B) components were determined by means of a pixel to pixel scanning algorithm, which were used to obtain the VI.

The values of red, green and blue (R, G, B) of the images were determined and the following vegetation indexes were analyzed:V (Wang et al., 2013); ExG, CIVE, VEG and ExGR (GUIJARRO et al., 2011 & YANG et al., 2015); COM and GN (YANG et al., 2015).

The vegetation indexes selected were the ones that showed the highest correlation between nitrogen values ​​obtained in the laboratory through bromatological analyzes of the brachiaria samples in the field.

Description of input images: <br />
https://giia.pirassununga.net/scc5830_project/images/pqt1_1-f1_02-12-2017-fb.JPG

The program in PHP makes the segmentation of the image with white background by giving the image in two objects (leaves of brachiaria and the white background of the image). To perform the segmentation of the images, a threshold algorithm was used that makes the autocorrection of the binary threshold.

Link to access the online application: <br />
https://scc5830-project.pirassununga.net

The PHP program targets the image with a white background, dividing the image into two objects (brachiaria leaves and the white background of the image). To perform the segmentation of the images, a threshold autocorrection and algorithm were used.

After segmentation and separation of the background through the threshold algorithm, pixel-pixel scanning of the image is performed in order to obtain the mean of the R, G and B channels, following the calculation of the vegetation indices, that will serve as entry for the training of the Artificial Neural Network(ANN).



# 2 Partial report
Title: Estimating the nutritional status of nitrogen in Brachiaria decumbens cv. Basilisk. <br />
Student: Adriano Aparecido Virgílio - nº usp:9877082 <br />
Main objective:
To develop software capable of estimating nitrogen concentration in Brachiaria decumbens cv. Basilisk from the analysis of diagnostic leaf images and thus define the N status of the crop and to evaluate the correlation between vegetation indices, based on RGB obtained from digital images, and the nitrogen concentration in diagnostic leaves of Brachiaria decumbens cv. Basilisk.

Description of input images:
https://giia.pirassununga.net/scc5830_project/images/pqt1_1-f1_02-12-2017-fb.JPG


# 1 Proposal
# Estimating the nutritional status of nitrogen
Title: Estimating the nutritional status of nitrogen in Brachiaria decumbens cv. Basilisk. <br />
Student: Adriano Aparecido Virgílio - nº usp:9877082 <br />

# Estimating the nutritional status of nitrogen
Title: Estimating the nutritional status of nitrogen in Brachiaria decumbens cv. Basilisk. <br />
Student: Adriano Aparecido Virgílio - nº usp:9877082 <br />
Abstract: To develop software capable of estimating nitrogen concentration in Brachiaria decumbens cv. Basilisk from the analysis of diagnostic leaf images and thus define the N status of the crop. JPEG images acquired from a whiteboard smartphone will be submitted to the software prototype developed in PHP Language for pixel pixel scanning to determine the mean values of the red (R), green (G) and blue (B) components, in order to generate Indices of vegetation (IV).
