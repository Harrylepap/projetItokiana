/**
 * Les variables du panorama
 *
 */

var bManualControl = false;// contrôle manuel du panorama
var longitude = 155;
var latitude = -5;

var savedX;
var savedY;
var savedLongitude;
var savedLatitude;

var camera;
var renderer;
var scene;
var sphereMaterial;

var aPanoramaImages;
var iPanoramaImageChoice;


document.addEventListener("DOMContentLoaded", Main, true);


/**
 * Fonction principale
 * Appelée au chargement de la page
 *
 */
function Main()
{
    console.log("Main");

    //aPanoramaImages = ["assets/01.jpg","assets/02.jpg","assets/03.jpg","assets/04.jpg","assets/05.jpg","assets/06.jpg"];
    aPanoramaImages =["../img/test2.jpg"];

    iPanoramaImageChoice = Math.floor( Math.random() * aPanoramaImages.length );

    renderer = new THREE.WebGLRenderer();
    //renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setSize(1150, 450);

    document.getElementById("visite").appendChild(renderer.domElement);

    scene = new THREE.Scene();

    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
    camera.target = new THREE.Vector3(0, 0, 0);

    var sphere = new THREE.SphereGeometry(100, 100, 40);
    sphere.applyMatrix(new THREE.Matrix4().makeScale(-1, 1, 1));

    sphereMaterial = new THREE.MeshBasicMaterial();
    sphereMaterial.map = THREE.ImageUtils.loadTexture(aPanoramaImages[iPanoramaImageChoice])

    var sphereMesh = new THREE.Mesh(sphere, sphereMaterial);
    scene.add(sphereMesh);

    document.addEventListener("mousedown", onDocumentMouseDown, false);
    document.addEventListener("mousemove", onDocumentMouseMove, false);
    document.addEventListener("mouseup", onDocumentMouseUp, false);

    renderPanorama();
}


/**
 * le rendu de l'image
 *
 * @return {[type]} [description]
 */
function renderPanorama()
{
    requestAnimationFrame(renderPanorama);

    // si mode autoamtique
    if(!bManualControl)

        longitude += 0;

    // limitation de la latitude entre -85 et 85 (impossible de voir le ciel ou vos pieds)
    latitude = Math.max(-100, Math.min(100, latitude));

    // déplace la caméra en fonction de la latitude (mouvement vertical) et de la longitude (mouvement horizontal)
    camera.target.x = 500 * Math.sin(THREE.Math.degToRad(90 - latitude)) * Math.cos(THREE.Math.degToRad(longitude));
    camera.target.y = 500 * Math.cos(THREE.Math.degToRad(90 - latitude));
    camera.target.z = 500 * Math.sin(THREE.Math.degToRad(90 - latitude)) * Math.sin(THREE.Math.degToRad(longitude));
    camera.lookAt(camera.target);

    renderer.render(scene, camera);
}


/**
 * lors du l'appui sur la souris,
 * passage en mode manuel.
 * Sauvegarde les coordonnées courantes
 *
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
function onDocumentMouseDown(event)
{
    event.preventDefault();

    bManualControl = true;

    savedX = event.clientX;
    savedY = event.clientY;

    savedLongitude = longitude;
    savedLatitude = latitude;
}


/**
 * Au déplacement de la souris,
 * mets à jour les coordonnées.
 *
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
function onDocumentMouseMove(event)
{
    // mise à jour si mode manuel
    if(bManualControl)
    {
        longitude = (savedX - event.clientX) * 0.1 + savedLongitude;
        latitude = (event.clientY - savedY) * 0.1 + savedLatitude;
    }
}


/**
 * Relachement du bouton de la souris,
 * passage en mode automatique
 *
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
function onDocumentMouseUp(event)
{
    bManualControl = false;
}



/**
 * Sur appui de la flèche haut,
 * modifie l'image
 *
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
document.onkeyup = function(event)
{
    console.log("onkeyup");

    // sélection d'une nouvelle image à mettre en panorama
    iPanoramaImageChoice = (iPanoramaImageChoice + 1) % aPanoramaImages.length

    // création du panorama
    sphereMaterial.map = THREE.ImageUtils.loadTexture(aPanoramaImages[iPanoramaImageChoice])
}
