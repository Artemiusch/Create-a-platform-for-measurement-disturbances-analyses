<div class="row">
    <div class="col-12">
        <p>Platforma symulacyjna służy do analizowania części szumowej sygnału.  Jako element wejściowy mamy sygnał, który może być wygenerowany lub rzeczywisty.  Sterownikiem jest algorytm filtracji sygnału. Element wyjściowy – szum.</p>
        <span class="image-wrap">
            <span class="image">
                <img src="images/img1.jpg" alt="">
            </span>
            <span class="image-title">Koncepcja Pracy</span>
        </span>
    </div>
    <div class="col-12">
        <div class="nav nav-tabs" role="tablist">
            <a class="nav-item nav-link active" id="sygnal-tab" data-toggle="tab" href="#sygnal" role="tab" aria-controls="nav-sygnal" aria-selected="true">Sygnał</a>
            <a class="nav-item nav-link" id="szum-tab" data-toggle="tab" href="#szum" role="tab" aria-controls="szum" aria-selected="false">Szum</a>
            <a class="nav-item nav-link" id="zaklocenia-tab" data-toggle="tab" href="#zaklocenia" role="tab" aria-controls="zaklocenia" aria-selected="false">Zakłócenia</a>
            <a class="nav-item nav-link" id="akcelerometr-tab" data-toggle="tab" href="#akcelerometr" role="tab" aria-controls="akcelerometr" aria-selected="false">Akcelerometr</a>
            <a class="nav-item nav-link" id="zyroskop-tab" data-toggle="tab" href="#zyroskop" role="tab" aria-controls="zyroskop" aria-selected="false">Żyroskop</a>
            <a class="nav-item nav-link" id="odchylenie-allana-tab" data-toggle="tab" href="#odchylenie-allana" role="tab" aria-controls="odchylenie-allana" aria-selected="false">Odchylenie Allana</a>
        </div>
        <div class="tab-content py-4">
            <div id="sygnal" class="tab-pane fade show active" role="tabpanel" aria-labelledby="sygnal-tab">
                <h2>Sygnał</h2>
                <p>
                    Sygnałem nazywamy pewną wielkość, której wartość może zostać zmierzona i która umożliwia przenoszenie informacji.<br/>
                    Róznego typu sygnałów jest nieskonczenie wiele i z tego powodu zostałe one podzielone na grupy.
                </p>
                <p>Przykłady sygnałów:</p>
                <table dir="LTR" style="width: 745.817px; margin: 0 auto;" border="0" cellspacing="0" cellpadding="7">
                    <tbody>
                        <tr>
                            <td style="width: 165px;"  height="65">
                                <h4>Mówienie</h4>
                            </td>
                            <td style="width: 545.817px;">
                                <p><img src="images/gr1.jpg" /></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 165px;"  height="152">
                                <h4>Wykres temparatury</h4>
                            </td>
                            <td style="width: 545.817px;">
                                <p><img src="images/gr2.png" /></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 165px;" height="107">
                                <h4>Elektrokardiografia</h4>
                            </td>
                            <td style="width: 545.817px;">
                                <p><img src="images/gr3.png" /></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 165px;" height="107">
                                <h4>Zdjęcie</h4>
                            </td>
                            <td style="width: 545.817px;" align="CENTER">
                                <p><img src="images/gr4.png" /></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="szum" class="tab-pane fade" role="tabpanel" aria-labelledby="sygnal-tab">
                <h2>Szum</h2>
                <blockquote class="blockquote">
                    <p class="mb-0">Organizm przeciwstawia się chaosowi, dezintegracji, śmierci, podobnie jak sygnał przeciwstawia się szumowi.</p>
                    <footer class="blockquote-footer"><cite title="Norbert Wiener">Norbert Wiener</cite></footer>
                </blockquote>
                <p>Szum ze swojej natury jest zjawiskiem chaotycznym i zawsze istnieje razem z sygnałem. Dlatego całkowite usunięcie składników szumowych nie jest możliwe, jednak używając odpowienich filtrów mianowice: falkowe odszumianie (ang. Wavelet denoising) lub filtr medianowy (ang. Median filter denoising) można zniwelować wpływ składników szumowych do minimum.</p>
            </div>
            <div id="zaklocenia" class="tab-pane fade" role="tabpanel" aria-labelledby="zaklocenia-tab">
                <h2>Zakłócenia</h2>
                <p>Zakłócenia – niepożądane składniki zewnętrzne, które występują w sygnałach. Zakłócenia mogą być spowodowane z winy:</p>
                <ul>
                    <li>Człowieka – stacje bazowe, zagłuszania sygnałów</li>
                    <li>Natury – promieniowanie słoneczne, klęski zywiołowe</li>
                    <li>Odbiornika – brak technologii, którą wysyłamy sygnał</li>
                </ul>
                <p>Zakłócenie traktowane jako zewnętrzne „niepożądane” składniki, które są do przewidzenia i można ich zniwelować wieloma sposobami. Użycie odpowiedniej technologii, konstrukcju, wzoru matematycznego lub zmiana dyslokacji urządzenia.</p>
            </div>
            <div id="akcelerometr" class="tab-pane fade" role="tabpanel" aria-labelledby="akcelerometr-tab">
                <h2>Akcelerometr – co to?</h2>
                <p>Urządzenie, które mierzy własny ruch w przestrzeni. Może być użyte do określenia połorzenia telefonu mierząc przyspieszenia liniowe. Znajdują się w niemal wszystkich smartfonach produkowanych dzisiaj.</p>

                <h2>Do czego służy?</h2>
                <p>Do diagnostyki pracy maszyn, urządzeń czy konstrukcji poddawanych dużym naprężeniom, np. konstrukcji stalowych masztów, mostów czy obiektów budowlanych. Akcelerometry stosowane są również m.in. do ochrony dysków twardych przed uszkodzeniem, w sprzęcie medycznym i sportowym, w aparatach i kamerach, w smartfonach, pilotach, kontrolerach czy w systemach nawigacji.</p>
                
                <h2>Z czego się składa?</h2>
                <p>Do niedawna był on wykorzystywany głównie w grach przy zmianie orientacji ekranu. Ostatnio jednak dzięki popularyzacji technologii VR na żyroskop spada o wiele więcej obowiązków. Teraz telefon musi śledzić dokładne położenie głowy i robić to możliwie jak najszybciej i precyzyjniej, tak by móc jak najlepiej oszukać mózg i dać lepsze wrażenia z zabawy wirtualną rzeczywistością.</p>
            </div>
            <div id="zyroskop" class="tab-pane fade" role="tabpanel" aria-labelledby="zyroskop-tab">
                <h2>Żyroskop – co to?</h2>
                <p>Słowo żyroskop ma dwa znaczenia: może to być zarówno urządzenie, które utrzymuje położenie kątowe, jak i urządzenie które takie położenie mierzy. Te drugie znajdują się w niemalże wszystkich produkowanych dzisiaj smartfonach.</p>

                <h2>Do czego służy?</h2>
                <p>Do niedawna był on wykorzystywany głównie w grach przy zmianie orientacji ekranu. Ostatnio jednak dzięki popularyzacji technologii VR na żyroskop spada o wiele więcej obowiązków. Teraz telefon musi śledzić dokładne położenie głowy i robić to możliwie jak najszybciej i precyzyjniej, tak by móc jak najlepiej oszukać mózg i dać lepsze wrażenia z zabawy wirtualną rzeczywistością.</p>
                
                <h2>Z czego się składa?</h2>
                <p>Żyroskop zbudowany jest z mikroskopijnych płytek, które wibrują wraz ze zmianą wysokości (i w efekcie ciśnienia). Przez sensory w nich umieszczone można precyzyjnie określić względne położenie urządzenia.</p>

                <h2>Żyroskop  i Akcelerometr - różnica?</h2>
                <table border="1" width="658" cellspacing="0" cellpadding="7" style="margin:0 auto;">
                    <tbody>
                        <tr>
                            <td width="325" align="center">
                                <p><b>Żyroskop</b></p>
                            </td>
                            <td width="303" align="center">
                                <p><b>Akcelerometr</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="325">
                                <p>Wyznacza kąt nachy<span>l</span>enia odnośnie powierzchni Ziemi</p>
                            </td>
                            <td width="303">
                                <p>Wyznacza przyspierzenie odnośnie powierzchni Ziemi</p>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#f1f1f1" width="325">
                                <p>Nie możemy go urzywać do pomiaru czasu trwania ruchu urządzenia</p>
                            </td>
                            <td bgcolor="#f1f1f1" width="303">
                                <p>Możemy go urzyć do pomiaru czasu trwania ruchu urządzenia</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="odchylenie-allana" class="tab-pane fade" role="tabpanel" aria-labelledby="odchylenie-allana-tab">
                <h2>Odchyłenia Allana</h2>
                <p>Do analizy składników szumowych sygnału stosuje się wariancji Allana. Do budowy wykresu należy obliczyć odchylenie Allana. Wykres buduje się w skali log-log przedstawia zależność odchylenie Allana 𝝈(τ) od czasu uśrednienia τ.</p>
                <span class="image-wrap">
                    <span class="image">
                        <img src="images/allan.png" alt="">
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>