<div class="container">            
    <div id="application_form_layout" >
        <form name="application_form" id="application_form" class="needs-validation" novalidate method="POST" action="#">
            
            <div><?= writeCSRFToken() ?></div>
            <div class="row" style="width: 100%; text-align: center">
                <div class="col-sm-12">
                    <h4>FORM NO. 13</h4>
                    <p><i>(Civil) <br/> (Rule 18, Chapter XII)</i></p>
                    <h3>Form of Application for Copy</h3>
                    <p style="color: #d50000; font-size: 10pt;">#Note: The fields labeled with * symbols are mandatory.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="urgent_ordinary" class="control-label">Application for (*):</label>
                </div>
                <div class="col-sm-6">
                    <select name="urgent_ordinary" id="urgent_ordinary" class="custom-select  small_font" required>
                        <option value="">-- Select --</option>
                        <option value="Urgent Copy">Urgent Copy</option>
                        <option value="Ordinary Copy">Ordinary Copy</option>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please select whether urgent or ordinary.</div>
                </div>
            </div>

            <div class="row"  >
                <div class="col-sm-4">
                    <label for="certificate_type_id" class="control-label">Case type (*):</label>
                </div>
                <div class="col-sm-6">
                    <select name="case_type" id="case_type" class="custom-select small_font" required>
                        <option value="">Select Case Type</option>
                        <option value="150">AB - Anticipatory Bail(150)</option>
                        <option value="86">Adml.S. - Admiralty Suits(86)</option>
                        <option value="63">Arb.A - Appeals under Indian Arbitration Act.(63)</option>
                        <option value="143">Arb.A(J2) - Arb.Appeal of J-2(143)</option>
                        <option value="62">Arb.P. - Petition under Indian Arbitration Act.(62)</option>
                        <option value="142">Arb.P.(J2) - Arb.Petn. of Judl-2(142)</option>
                        <option value="151">BA - Bail Application(151)</option>
                        <option value="93">BAIL APPLN. - Bail Application(93)</option><option value="42">Bkg.p. - Proceedings under Banking Regulation Act.(42)</option><option value="152">CAPL - Contempt Appeal(152)</option><option value="153">CAV - Caveat(153)</option><option value="148">CAV(J2) - Caveat of Judl-2(148)</option>
                        <option value="149">Cav.Pet. - Caveat Petn. of J-2(149)</option>
                        <option value="154">CC(CIV) - Contempt Of Court (Civil)(154)</option>
                        <option value="75">CE.REf. - Reference under Central Excise Act(75)</option>
                        <option value="33">CMAppl. - Misc Applications eg Leave to Sue as indigent person, restoration application, condonat(33)</option><option value="23">CO - Cross Objection in First Appeal(23)</option><option value="41">Co.App. - Appeals against Judgments/Orders in Company Petitions(41)</option><option value="39">Co. Appl. - Applicationin Pending Proceeding(39)</option>
                        <option value="155">COB(FA) - Cross Objection in First Appeal(155)</option>
                        <option value="156">COB(MFA) - Cross Objection in Misc. First Appeal(156)</option>
                        <option value="40">Co.Case - Matters transferred under Section 446(3)(40)</option>
                        <option value="157">COJO - Correction of Judgement/Order(157)</option>
                        <option value="158">COMAPL - Company Appeal(158)</option>
                        <option value="159">COMPET - Company Petition(159)</option>
                        <option value="67">Cont.App.(C) - Appeals against orders in Civil Contempt matters.(67)</option>
                        <option value="17">Cont.App(C) - Appeal against order in Civil Contempt matters(17)</option>
                        <option value="97">Cont.App.(Crl.) - Appeals against Orders in Criminal Contempt matters.(97)</option>
                        <option value="66">CONT.CAS(C) - Contempt of Court Cases relating to Civil Contempt.(66)</option>
                        <option value="5">CONT.CAS(C)J2 - Contempt of Court Cases relating to Civil Appeal cases(5)</option>
                        <option value="96">Cont.Cas.(Crl.) - Proceedings relating to Criminal Contempt.(96)</option>
                        <option value="160">COP(C) - Civil Original Petition( Contempt )(160)</option>
                        <option value="20">Co.Pet. - Company Petition(20)</option>
                        <option value="161">CR - Civil Rule(161)</option>
                        <option value="169">CRAPL - Criminal Appeal(169)</option>
                        <option value="162">CR(CC) - Criminal Contempt of Court(162)</option>
                        <option value="170">CRDREF - Criminal Death Reference(170)</option>
                        <option value="29">C.Ref. - Reference(29)</option>
                        <option value="171">CREF - Civil Refrence(171)</option>
                        <option value="172">CREV - Civil Revision(172)</option>
                        <option value="173">CREV(H) - Civil Revision(hills)(173)</option>
                        <option value="163">CR(HC) - Civil Rule(Habeas Corpus )(163)</option>
                        <option value="103">Cril. Petn. - Petition/applicants filed under S.482 of Cr.P.C.(103)</option>
                        <option value="88">Crl.A. - Appeal against Judgment/Sentence.(88)</option>
                        <option value="164">CR(LAB) - Civil Rule(labour)(164)</option>
                        <option value="165">CR(LAN) - Civil Rule(land)(165)</option>
                        <option value="146">Crl.J.A - Criminal Jail Appeeal of J-2(146)</option>
                        <option value="98">Crl.L.P. - App for Leaving to Appeal under Section 378 Cr.P.C. or under the relevant corresponding(98)</option>
                        <option value="94">Crl.M.Appln. - Other Miscellaneous Application(94)</option>
                        <option value="92">Crl.M.C. - Application under Section 482 Cr.P.C.(92)</option>
                        <option value="91">Crl.Ref. - Reference(91)</option>
                        <option value="90">Crl.Rev.P. - Revision(90)</option>
                        <option value="87">Crl.Tr. - Original Trial(87)</option>
                        <option value="166">CR(MC) - Criminal Misc. Case(166)</option><option value="174">CROA - Criminal Original Application(174)</option><option value="175">CROP - Criminal Original Application(175)</option><option value="176">CROP(C) - Criminal Original Petition(Contempt)(176)</option><option value="167">CR(OTH) - Civil Rule(other)(167)</option><option value="27">CRP - Revision Petition(27)</option><option value="104">CRP(C.R.P. Art.227) - Writ Petition under Article 227  of the Constitution(104)</option><option value="213">CR(PIL) - Civil Rule Pil(213)</option><option value="177">CRREF - Criminal Reference(177)</option><option value="178">CRREF(H) - Criminal reference(hills)(178)</option><option value="179">CRREV - Criminal Revision(179)</option><option value="168">CR(SER) - Civil Rule(service)(168)</option><option value="21">CS - Civil Suit(21)</option><option value="82">CS(OS) - Civil Suits(82)</option><option value="74">Cus.Ref. - Reference under Customs Act.(74)</option><option value="89">Death Sentence Ref. - Confirmation case under Section 336 Cr.P.C.(89)</option><option value="180">EDREF - Estate Duty Reference(180)</option><option value="59">EL.App. - Appeals from judgments in Election(59)</option><option value="58">EL.PET. - Election Petition(58)</option><option value="147">El.Recr.Pet - Eln. Recremination Petn. of J-2(147)</option><option value="84">Ex.Appl.(OS) - Execution Application(84)</option><option value="30">Ex.FA. - Execution Petition(30)</option><option value="211">Ex.P. - Execution Petition(211)</option><option value="31">Ex.SA. - Execution Second Appeal(31)</option><option value="181">FA - First Appeal(181)</option><option value="182">FA(D) - First Appeal(Divorce)(182)</option><option value="24">FAO - First Appeal from Orders(24)</option><option value="11">FAO(G) - First Appeal from orders(G)(11)</option><option value="12">FAO(Intest) - First Appeal from orders(Intest)(12)</option><option value="83">FA(OS) - First Appeal for Judgments in Original Suits.(83)</option><option value="13">FAO(Test) - First Appeal from orders(Test)(13)</option><option value="183">FA(T) - First Appeal(183)</option><option value="184">GCA - Government Criminal Appeal(184)</option><option value="73">GTA/WTA/EDA - Application for direction to make a reference(73)</option><option value="185">GTREF - Gift Tax Reference(185)</option><option value="72">GTR/WTR/EDR - Reference to High Court(72)</option><option value="49">Gua.p. - Petitions under Guarduanship and Wards Act.(49)</option><option value="32">IA - Interiocutory applications in pending Suits/Appeals(32)</option><option value="65">Insurance App. - Appeals under Insurance Act.(65)</option><option value="64">Insurance REf. - Reference under Insurance Act.(64)</option><option value="48">Intest. Cas. - Intestate cases,e.g., Succession Certificates, etc.(48)</option><option value="61">IP(Appl.) - Application submitted after adjudication(61)</option><option value="60">IP(M) - Main Petition(60)</option><option value="71">ITA - Application under Section 256(2)(71)</option><option value="70">ITR - Reference under Section 256(1)(70)</option><option value="186">ITREF - Income Tax Reference(186)</option><option value="51">LA.App. - Appeals(51)</option><option value="50">LA.Ref. - Reference(50)</option><option value="187">LPA - Latters Patent Appeal(187)</option><option value="144">LPA(J2) - LPA of J-2(144)</option><option value="56">MAC - Motor Accident Claims(56)</option><option value="57">MACApp. - Motor Accident Appeal(57)</option><option value="188">MAF - Miscellaneous Appeal(first)(188)</option><option value="189">MAF(T) - Miscellaneous Appeal First(tender)(189)</option><option value="45">Mat.App. - Appeals(45)</option><option value="43">Mat. Cas. - Suits/Petitions(43)</option><option value="44">Mat. Reg. - Reference(44)</option><option value="190">MC - Miscellaneous Case(190)</option><option value="131">MC(Arb.A.) - Misc. Case of Appeal under Indian Arbitration Act.(131)</option><option value="8">MC(Arb.A.(J2)) - Misc. Case of appeal  under Indian Arbitration Act.(8)</option><option value="130">MC(Arb.P.) - Misc. Case of Petition under Indian Arbitration Act.(130)</option><option value="7">MC(Arb.P.(J2)) - Misc. Case of Petition under Indian Arbitration Act.(7)</option><option value="137">MC(Bail Appln.) - Misc. Case of Bail Application(137)</option><option value="113">MC(CAPL) - Misc. Case of Contempt Appeal(113)</option><option value="133">MC(Cont.App.(C)) - Misc. Case of Appeals against orders in Civil Contempt matters(133)</option><option value="140">MC(Cont.App.(Crl.)) - Misc. Case of Appeals against orders of Criminal Contempt matters(140)</option><option value="132">MC(CONT.CAS(C)) - Misc. Case of Contempt of Court Cases relating to Civil Contempt(132)</option><option value="9">MC(CONT.CAS(C)J2) - Misc Contempt of Court Cases relating to Civil Appeal cases(9)</option><option value="139">MC(CONT.CAS(Crl.)) - Misc. Case of Proceedings relating to Criminal Contempt(139)</option><option value="102">MC(CR) - Misc. Case of Civil Rule(102)</option><option value="3">MC(CR(HC)) - Misc Case of CR(Habeas Corpus)(3)</option><option value="106">MC(Cril. Petn.) - misc. crl Petition/applicants filed under S.482 of Cr.P.C.(106)</option><option value="135">MC(Crl.A.) - Misc. Case of Appeal against Judgment/Sentence(135)</option><option value="1">MC(Crl.J.A.) - Cril Misc of Cril Jail appeal(1)</option><option value="136">MC(Crl.Rev.P.) - Misc. Case of Revision(136)</option><option value="119">MC((CRP) - Misc. Case of Revision Petition(119)</option><option value="2">MC(CRP(CRP Art.227) - Misc Case of CRP(C.R.P. Art.227)(2)</option><option value="214">MC(CR(PIL)) - Misc Civil Rule Pil(214)</option><option value="115">MC(CS) - Misc. Case of Civil Suit(115)</option><option value="129">MC(El.Pet.) - Misc. Case of Election Petitions(129)</option><option value="105">MC(EP) - Misc. Case of Election Petition(105)</option><option value="121">MC(Ex.P.) - Misc. Case of Execution Petition(121)</option><option value="108">MC(FA) - Misc. Case of First Appeal(108)</option><option value="117">MC(FAO) - Misc. Case of First Appeal from Orders(117)</option><option value="14">MC(FAO(G)) - Misc.Case first Appeal from orders(G)(14)</option><option value="16">MC(FAO(Intest)) - Misc.Case first Appeal from orders(Intest)(16)</option><option value="15">MC(FAO(test)) - Misc.Case first Appeal from orders(Test)(15)</option><option value="109">MC(GCA) - Misc. Case of Government Criminal Appeal(109)</option><option value="18">MC(LA.App.) - Misc. Land Acquisition Appeal(18)</option><option value="110">MC(LPA) - Misc. Case of Letters Patent Appeal(110)</option><option value="6">MC(LPA(J2)) - Misc case of LPA, judl 2(6)</option><option value="127">MC(MAC) - Misc. Case of Motor Accident Claims(127)</option><option value="128">MC(MACApp.) - Misc. Case of Motor Accident Appeal(128)</option><option value="111">MC(MAF) - Misc. Case of Miscellaneous Appeal (first)(111)</option><option value="125">MC(Mat.App.) - Misc. Case of Appeals(125)</option><option value="123">MC(Mat.Cas.) - Misc. Case of Suits/Petitions(123)</option><option value="124">MC(Mat.Ref.) - Misc. Case of References(124)</option><option value="134">MC(MFA) - Misc. Case of First Appeal against judgments in Special jurisdiction(134)</option><option value="107">MC(OC) - Misc. Case of Original Case(107)</option><option value="114">MC(PIL) - Misc. Case of Public Interest Litigation(114)</option><option value="120">MC(Review.Pet.) - Misc. Case of Review Petition(120)</option><option value="216">MC(Review Pet.(Crl.)) - Misc case Review petition (Cril)(216)</option><option value="4">MC(Rev.Pet(J2)) - MISC OF REVIEW PETITION J2(4)</option><option value="116">MC(RFA) - Misc. Case of First Appeal from Judgment and Decree in Suit(116)</option><option value="212">MC(RP(FAM.CT)) - Misc. Case Of Revisions Under Section 19 Of The Family Courts Act.(212)</option><option value="118">MC(RSA) - Misc. Case of Second Appeal from Judgment and Decree(118)</option><option value="112">MC(RSA(Rev.)) - Misc. Case of Review in Second Appeal(112)</option><option value="191">MC(SA) - Misc.Case in Second Appeal(191)</option><option value="19">MC(SA) - Misc Case Second Appeal(19)</option><option value="10">MC(SAO) - Misc of SAO(10)</option><option value="126">MC(Test.Cas.) - Misc. Case of Testamentary cases,e.g.,Probate or Letters of Administration(126)</option><option value="122">MC(Tr.P.(C)) - Misc.Case of Transfer Petition under Section 24 C.P.C.(122)</option><option value="141">MC(Tr.P.(Crl.)) - Misc. Case of Transfer Petition for transfer a Criminal Proceeding(141)</option><option value="101">MC(WA) - Misc.Case of Appeal before Division Bench against judgment or order(101)</option><option value="100">MC(WP(C)) - Misc.Case of Writ Petition under Article 226  of the Constitution(100)</option><option value="138">MC(W.P.(Crl.)) - Misc. Case of Petition under Article 226 for writ and Haveas Corpus(138)</option><option value="68">MFA - First Appeal against judgments in Special Jurisdiction cases.(68)</option><option value="69">MSA - Second Appeal from judgments in miscellaneous cases.(69)</option><option value="85">N.M. - Notice of Motion(85)</option><option value="38">Or.Pet. - Original Petition(38)</option><option value="192">OTA - Other Tax Application(192)</option><option value="81">OT.Appl. - Other Tax Application(81)</option><option value="80">OTC - Other Tax Cases(80)</option><option value="79">OTR - Other Tax Reference cases(79)</option><option value="36">PIL - Public Interest Litigation(36)</option><option value="193">RA(CR) - Review Application in Civil Rule(193)</option><option value="194">RA(FA) - Review Application in First Appeal(194)</option><option value="195">RA(MFA) - Review Application in Misc. First Appeal(195)</option><option value="196">RAT - Review Application (Tender)(196)</option><option value="52">RCC - Original Suit/Petition(52)</option><option value="53">RCFA - First Appeal(53)</option><option value="54">RCSA - Second Appeal(54)</option><option value="55">RECREv. - Revision(55)</option><option value="197">REP - Recrimination Case in Election Petition(197)</option><option value="28">Review.Pet. - Review Petition(28)</option><option value="215">Review Pet.(Crl.) - Review Petition (Cril)(215)</option><option value="145">Rev.Pet(J2) - Review Petn. of J-2(145)</option><option value="22">RFA - First Appeal from Judgment Decree in Suit(22)</option><option value="198">RLPA - Review in Latters Patent Appeal(198)</option><option value="46">RP(FAM.CT.) - Revisions under section 19 of the Family Courts Act.(46)</option><option value="25">RSA - Second Appeal from Judgment Decree(25)</option><option value="199">RSA(Rev) - Review in Second Appeal(199)</option><option value="200">SA - Second Appeal(200)</option><option value="26">SAO - Appeal from Appellate Order(26)</option><option value="201">SA(T) - Second Appeal(tender)(201)</option><option value="37">SCLP - Petition for Leave to Appeal to Supreme Court(37)</option><option value="77">ST.Appl. - Application for direction to make a reference(77)</option><option value="76">ST.REf. - Reference(76)</option><option value="202">STREF - Sales Tax Refrence(202)</option><option value="78">ST.Rev. - Revision(78)</option><option value="47">Test.Cas. - Testamentary cases, e.g., Probate or Letters of Administration, etc.(47)</option><option value="34">Tr.P.(C) - Transfer Petition under Section 24 C.P.C.(34)</option><option value="99">Tr.P.(Crl.) - Transfer Petition for transfer a Criminal Proceeding(99)</option><option value="203">WA - Writ Appeal(203)</option><option value="204">WA(FA) - WRIT APPEAL IN FA(204)</option><option value="205">WA(LAB) - Writ Appeal(labour)(205)</option><option value="206">WA(LAN) - Writ Appeal(land)(206)</option><option value="207">WA(OTH) - Writ Appeal(others)(207)</option><option value="208">WA(SER) - Writ Appeal(service)(208)</option><option value="209">WA(T) - Writ Appeal Tender(209)</option><option value="35">WP(C) - Writ Petition under Article 226  of the Constitution(35)</option><option value="95">W.P.(Crl.) - Petition under Art226 for Writ and Habeas Corpus and other relief in relation to a Crimina(95)</option><option value="210">WTREF - Wealth Tax Refrence(210)</option>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please select case type.</div>
                </div>
            </div>

            <div class="row"  >
                <div class="col-sm-4">
                    <label class="control-label" for="case_no">Case No. (*):</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" onkeypress="return isNumber(event);" name="case_no" id="case_no" class="form-control" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill case no.</div>
                </div>
            </div>
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="case_year" class="control-label">Case Year (*):</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" onkeypress="return isNumber(event);" name="case_year" id="case_year" class="form-control" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill case year.</div>
                </div>
            </div>
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="reference" class="control-label">Reference (if any):</label>
                </div>
                <div class="col-sm-6">
                    <div style="margin-bottom: 10px;">
                        <select name="case_type_reference" id="case_type_reference" class="custom-select small_font">
                            <option value="">Select Case Type for reference</option>
                            <option value="150">AB - Anticipatory Bail(150)</option>
                            <option value="86">Adml.S. - Admiralty Suits(86)</option>
                            <option value="63">Arb.A - Appeals under Indian Arbitration Act.(63)</option>
                            <option value="143">Arb.A(J2) - Arb.Appeal of J-2(143)</option>
                            <option value="62">Arb.P. - Petition under Indian Arbitration Act.(62)</option>
                            <option value="142">Arb.P.(J2) - Arb.Petn. of Judl-2(142)</option>
                            <option value="151">BA - Bail Application(151)</option>
                            <option value="93">BAIL APPLN. - Bail Application(93)</option><option value="42">Bkg.p. - Proceedings under Banking Regulation Act.(42)</option><option value="152">CAPL - Contempt Appeal(152)</option><option value="153">CAV - Caveat(153)</option><option value="148">CAV(J2) - Caveat of Judl-2(148)</option>
                            <option value="149">Cav.Pet. - Caveat Petn. of J-2(149)</option>
                            <option value="154">CC(CIV) - Contempt Of Court (Civil)(154)</option>
                            <option value="75">CE.REf. - Reference under Central Excise Act(75)</option>
                            <option value="33">CMAppl. - Misc Applications eg Leave to Sue as indigent person, restoration application, condonat(33)</option><option value="23">CO - Cross Objection in First Appeal(23)</option><option value="41">Co.App. - Appeals against Judgments/Orders in Company Petitions(41)</option><option value="39">Co. Appl. - Applicationin Pending Proceeding(39)</option>
                            <option value="155">COB(FA) - Cross Objection in First Appeal(155)</option>
                            <option value="156">COB(MFA) - Cross Objection in Misc. First Appeal(156)</option>
                            <option value="40">Co.Case - Matters transferred under Section 446(3)(40)</option>
                            <option value="157">COJO - Correction of Judgement/Order(157)</option>
                            <option value="158">COMAPL - Company Appeal(158)</option>
                            <option value="159">COMPET - Company Petition(159)</option>
                            <option value="67">Cont.App.(C) - Appeals against orders in Civil Contempt matters.(67)</option>
                            <option value="17">Cont.App(C) - Appeal against order in Civil Contempt matters(17)</option>
                            <option value="97">Cont.App.(Crl.) - Appeals against Orders in Criminal Contempt matters.(97)</option>
                            <option value="66">CONT.CAS(C) - Contempt of Court Cases relating to Civil Contempt.(66)</option>
                            <option value="5">CONT.CAS(C)J2 - Contempt of Court Cases relating to Civil Appeal cases(5)</option>
                            <option value="96">Cont.Cas.(Crl.) - Proceedings relating to Criminal Contempt.(96)</option>
                            <option value="160">COP(C) - Civil Original Petition( Contempt )(160)</option>
                            <option value="20">Co.Pet. - Company Petition(20)</option>
                            <option value="161">CR - Civil Rule(161)</option>
                            <option value="169">CRAPL - Criminal Appeal(169)</option>
                            <option value="162">CR(CC) - Criminal Contempt of Court(162)</option>
                            <option value="170">CRDREF - Criminal Death Reference(170)</option>
                            <option value="29">C.Ref. - Reference(29)</option>
                            <option value="171">CREF - Civil Refrence(171)</option>
                            <option value="172">CREV - Civil Revision(172)</option>
                            <option value="173">CREV(H) - Civil Revision(hills)(173)</option>
                            <option value="163">CR(HC) - Civil Rule(Habeas Corpus )(163)</option>
                            <option value="103">Cril. Petn. - Petition/applicants filed under S.482 of Cr.P.C.(103)</option>
                            <option value="88">Crl.A. - Appeal against Judgment/Sentence.(88)</option>
                            <option value="164">CR(LAB) - Civil Rule(labour)(164)</option>
                            <option value="165">CR(LAN) - Civil Rule(land)(165)</option>
                            <option value="146">Crl.J.A - Criminal Jail Appeeal of J-2(146)</option>
                            <option value="98">Crl.L.P. - App for Leaving to Appeal under Section 378 Cr.P.C. or under the relevant corresponding(98)</option>
                            <option value="94">Crl.M.Appln. - Other Miscellaneous Application(94)</option>
                            <option value="92">Crl.M.C. - Application under Section 482 Cr.P.C.(92)</option>
                            <option value="91">Crl.Ref. - Reference(91)</option>
                            <option value="90">Crl.Rev.P. - Revision(90)</option>
                            <option value="87">Crl.Tr. - Original Trial(87)</option>
                            <option value="166">CR(MC) - Criminal Misc. Case(166)</option><option value="174">CROA - Criminal Original Application(174)</option><option value="175">CROP - Criminal Original Application(175)</option><option value="176">CROP(C) - Criminal Original Petition(Contempt)(176)</option><option value="167">CR(OTH) - Civil Rule(other)(167)</option><option value="27">CRP - Revision Petition(27)</option><option value="104">CRP(C.R.P. Art.227) - Writ Petition under Article 227  of the Constitution(104)</option><option value="213">CR(PIL) - Civil Rule Pil(213)</option><option value="177">CRREF - Criminal Reference(177)</option><option value="178">CRREF(H) - Criminal reference(hills)(178)</option><option value="179">CRREV - Criminal Revision(179)</option><option value="168">CR(SER) - Civil Rule(service)(168)</option><option value="21">CS - Civil Suit(21)</option><option value="82">CS(OS) - Civil Suits(82)</option><option value="74">Cus.Ref. - Reference under Customs Act.(74)</option><option value="89">Death Sentence Ref. - Confirmation case under Section 336 Cr.P.C.(89)</option><option value="180">EDREF - Estate Duty Reference(180)</option><option value="59">EL.App. - Appeals from judgments in Election(59)</option><option value="58">EL.PET. - Election Petition(58)</option><option value="147">El.Recr.Pet - Eln. Recremination Petn. of J-2(147)</option><option value="84">Ex.Appl.(OS) - Execution Application(84)</option><option value="30">Ex.FA. - Execution Petition(30)</option><option value="211">Ex.P. - Execution Petition(211)</option><option value="31">Ex.SA. - Execution Second Appeal(31)</option><option value="181">FA - First Appeal(181)</option><option value="182">FA(D) - First Appeal(Divorce)(182)</option><option value="24">FAO - First Appeal from Orders(24)</option><option value="11">FAO(G) - First Appeal from orders(G)(11)</option><option value="12">FAO(Intest) - First Appeal from orders(Intest)(12)</option><option value="83">FA(OS) - First Appeal for Judgments in Original Suits.(83)</option><option value="13">FAO(Test) - First Appeal from orders(Test)(13)</option><option value="183">FA(T) - First Appeal(183)</option><option value="184">GCA - Government Criminal Appeal(184)</option><option value="73">GTA/WTA/EDA - Application for direction to make a reference(73)</option><option value="185">GTREF - Gift Tax Reference(185)</option><option value="72">GTR/WTR/EDR - Reference to High Court(72)</option><option value="49">Gua.p. - Petitions under Guarduanship and Wards Act.(49)</option><option value="32">IA - Interiocutory applications in pending Suits/Appeals(32)</option><option value="65">Insurance App. - Appeals under Insurance Act.(65)</option><option value="64">Insurance REf. - Reference under Insurance Act.(64)</option><option value="48">Intest. Cas. - Intestate cases,e.g., Succession Certificates, etc.(48)</option><option value="61">IP(Appl.) - Application submitted after adjudication(61)</option><option value="60">IP(M) - Main Petition(60)</option><option value="71">ITA - Application under Section 256(2)(71)</option><option value="70">ITR - Reference under Section 256(1)(70)</option><option value="186">ITREF - Income Tax Reference(186)</option><option value="51">LA.App. - Appeals(51)</option><option value="50">LA.Ref. - Reference(50)</option><option value="187">LPA - Latters Patent Appeal(187)</option><option value="144">LPA(J2) - LPA of J-2(144)</option><option value="56">MAC - Motor Accident Claims(56)</option><option value="57">MACApp. - Motor Accident Appeal(57)</option><option value="188">MAF - Miscellaneous Appeal(first)(188)</option><option value="189">MAF(T) - Miscellaneous Appeal First(tender)(189)</option><option value="45">Mat.App. - Appeals(45)</option><option value="43">Mat. Cas. - Suits/Petitions(43)</option><option value="44">Mat. Reg. - Reference(44)</option><option value="190">MC - Miscellaneous Case(190)</option><option value="131">MC(Arb.A.) - Misc. Case of Appeal under Indian Arbitration Act.(131)</option><option value="8">MC(Arb.A.(J2)) - Misc. Case of appeal  under Indian Arbitration Act.(8)</option><option value="130">MC(Arb.P.) - Misc. Case of Petition under Indian Arbitration Act.(130)</option><option value="7">MC(Arb.P.(J2)) - Misc. Case of Petition under Indian Arbitration Act.(7)</option><option value="137">MC(Bail Appln.) - Misc. Case of Bail Application(137)</option><option value="113">MC(CAPL) - Misc. Case of Contempt Appeal(113)</option><option value="133">MC(Cont.App.(C)) - Misc. Case of Appeals against orders in Civil Contempt matters(133)</option><option value="140">MC(Cont.App.(Crl.)) - Misc. Case of Appeals against orders of Criminal Contempt matters(140)</option><option value="132">MC(CONT.CAS(C)) - Misc. Case of Contempt of Court Cases relating to Civil Contempt(132)</option><option value="9">MC(CONT.CAS(C)J2) - Misc Contempt of Court Cases relating to Civil Appeal cases(9)</option><option value="139">MC(CONT.CAS(Crl.)) - Misc. Case of Proceedings relating to Criminal Contempt(139)</option><option value="102">MC(CR) - Misc. Case of Civil Rule(102)</option><option value="3">MC(CR(HC)) - Misc Case of CR(Habeas Corpus)(3)</option><option value="106">MC(Cril. Petn.) - misc. crl Petition/applicants filed under S.482 of Cr.P.C.(106)</option><option value="135">MC(Crl.A.) - Misc. Case of Appeal against Judgment/Sentence(135)</option><option value="1">MC(Crl.J.A.) - Cril Misc of Cril Jail appeal(1)</option><option value="136">MC(Crl.Rev.P.) - Misc. Case of Revision(136)</option><option value="119">MC((CRP) - Misc. Case of Revision Petition(119)</option><option value="2">MC(CRP(CRP Art.227) - Misc Case of CRP(C.R.P. Art.227)(2)</option><option value="214">MC(CR(PIL)) - Misc Civil Rule Pil(214)</option><option value="115">MC(CS) - Misc. Case of Civil Suit(115)</option><option value="129">MC(El.Pet.) - Misc. Case of Election Petitions(129)</option><option value="105">MC(EP) - Misc. Case of Election Petition(105)</option><option value="121">MC(Ex.P.) - Misc. Case of Execution Petition(121)</option><option value="108">MC(FA) - Misc. Case of First Appeal(108)</option><option value="117">MC(FAO) - Misc. Case of First Appeal from Orders(117)</option><option value="14">MC(FAO(G)) - Misc.Case first Appeal from orders(G)(14)</option><option value="16">MC(FAO(Intest)) - Misc.Case first Appeal from orders(Intest)(16)</option><option value="15">MC(FAO(test)) - Misc.Case first Appeal from orders(Test)(15)</option><option value="109">MC(GCA) - Misc. Case of Government Criminal Appeal(109)</option><option value="18">MC(LA.App.) - Misc. Land Acquisition Appeal(18)</option><option value="110">MC(LPA) - Misc. Case of Letters Patent Appeal(110)</option><option value="6">MC(LPA(J2)) - Misc case of LPA, judl 2(6)</option><option value="127">MC(MAC) - Misc. Case of Motor Accident Claims(127)</option><option value="128">MC(MACApp.) - Misc. Case of Motor Accident Appeal(128)</option><option value="111">MC(MAF) - Misc. Case of Miscellaneous Appeal (first)(111)</option><option value="125">MC(Mat.App.) - Misc. Case of Appeals(125)</option><option value="123">MC(Mat.Cas.) - Misc. Case of Suits/Petitions(123)</option><option value="124">MC(Mat.Ref.) - Misc. Case of References(124)</option><option value="134">MC(MFA) - Misc. Case of First Appeal against judgments in Special jurisdiction(134)</option><option value="107">MC(OC) - Misc. Case of Original Case(107)</option><option value="114">MC(PIL) - Misc. Case of Public Interest Litigation(114)</option><option value="120">MC(Review.Pet.) - Misc. Case of Review Petition(120)</option><option value="216">MC(Review Pet.(Crl.)) - Misc case Review petition (Cril)(216)</option><option value="4">MC(Rev.Pet(J2)) - MISC OF REVIEW PETITION J2(4)</option><option value="116">MC(RFA) - Misc. Case of First Appeal from Judgment and Decree in Suit(116)</option><option value="212">MC(RP(FAM.CT)) - Misc. Case Of Revisions Under Section 19 Of The Family Courts Act.(212)</option><option value="118">MC(RSA) - Misc. Case of Second Appeal from Judgment and Decree(118)</option><option value="112">MC(RSA(Rev.)) - Misc. Case of Review in Second Appeal(112)</option><option value="191">MC(SA) - Misc.Case in Second Appeal(191)</option><option value="19">MC(SA) - Misc Case Second Appeal(19)</option><option value="10">MC(SAO) - Misc of SAO(10)</option><option value="126">MC(Test.Cas.) - Misc. Case of Testamentary cases,e.g.,Probate or Letters of Administration(126)</option><option value="122">MC(Tr.P.(C)) - Misc.Case of Transfer Petition under Section 24 C.P.C.(122)</option><option value="141">MC(Tr.P.(Crl.)) - Misc. Case of Transfer Petition for transfer a Criminal Proceeding(141)</option><option value="101">MC(WA) - Misc.Case of Appeal before Division Bench against judgment or order(101)</option><option value="100">MC(WP(C)) - Misc.Case of Writ Petition under Article 226  of the Constitution(100)</option><option value="138">MC(W.P.(Crl.)) - Misc. Case of Petition under Article 226 for writ and Haveas Corpus(138)</option><option value="68">MFA - First Appeal against judgments in Special Jurisdiction cases.(68)</option><option value="69">MSA - Second Appeal from judgments in miscellaneous cases.(69)</option><option value="85">N.M. - Notice of Motion(85)</option><option value="38">Or.Pet. - Original Petition(38)</option><option value="192">OTA - Other Tax Application(192)</option><option value="81">OT.Appl. - Other Tax Application(81)</option><option value="80">OTC - Other Tax Cases(80)</option><option value="79">OTR - Other Tax Reference cases(79)</option><option value="36">PIL - Public Interest Litigation(36)</option><option value="193">RA(CR) - Review Application in Civil Rule(193)</option><option value="194">RA(FA) - Review Application in First Appeal(194)</option><option value="195">RA(MFA) - Review Application in Misc. First Appeal(195)</option><option value="196">RAT - Review Application (Tender)(196)</option><option value="52">RCC - Original Suit/Petition(52)</option><option value="53">RCFA - First Appeal(53)</option><option value="54">RCSA - Second Appeal(54)</option><option value="55">RECREv. - Revision(55)</option><option value="197">REP - Recrimination Case in Election Petition(197)</option><option value="28">Review.Pet. - Review Petition(28)</option><option value="215">Review Pet.(Crl.) - Review Petition (Cril)(215)</option><option value="145">Rev.Pet(J2) - Review Petn. of J-2(145)</option><option value="22">RFA - First Appeal from Judgment Decree in Suit(22)</option><option value="198">RLPA - Review in Latters Patent Appeal(198)</option><option value="46">RP(FAM.CT.) - Revisions under section 19 of the Family Courts Act.(46)</option><option value="25">RSA - Second Appeal from Judgment Decree(25)</option><option value="199">RSA(Rev) - Review in Second Appeal(199)</option><option value="200">SA - Second Appeal(200)</option><option value="26">SAO - Appeal from Appellate Order(26)</option><option value="201">SA(T) - Second Appeal(tender)(201)</option><option value="37">SCLP - Petition for Leave to Appeal to Supreme Court(37)</option><option value="77">ST.Appl. - Application for direction to make a reference(77)</option><option value="76">ST.REf. - Reference(76)</option><option value="202">STREF - Sales Tax Refrence(202)</option><option value="78">ST.Rev. - Revision(78)</option><option value="47">Test.Cas. - Testamentary cases, e.g., Probate or Letters of Administration, etc.(47)</option><option value="34">Tr.P.(C) - Transfer Petition under Section 24 C.P.C.(34)</option><option value="99">Tr.P.(Crl.) - Transfer Petition for transfer a Criminal Proceeding(99)</option><option value="203">WA - Writ Appeal(203)</option><option value="204">WA(FA) - WRIT APPEAL IN FA(204)</option><option value="205">WA(LAB) - Writ Appeal(labour)(205)</option><option value="206">WA(LAN) - Writ Appeal(land)(206)</option><option value="207">WA(OTH) - Writ Appeal(others)(207)</option><option value="208">WA(SER) - Writ Appeal(service)(208)</option><option value="209">WA(T) - Writ Appeal Tender(209)</option><option value="35">WP(C) - Writ Petition under Article 226  of the Constitution(35)</option><option value="95">W.P.(Crl.) - Petition under Art226 for Writ and Habeas Corpus and other relief in relation to a Crimina(95)</option><option value="210">WTREF - Wealth Tax Refrence(210)</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <input type="text" name="case_no_reference" placeholder="Refer to which case number" id="case_no_reference" class="form-control"/>
                    </div>
                    <div style="margin-bottom: 1px;">
                        <input type="text" name="case_year_reference" placeholder="Refer to which case year" id="case_year_reference" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="appel_petitioner" class="control-label">Appellant/Petitioner (*):</label>
                </div>
                <div class="col-sm-6">
                     <input type="text" name="appel_petitioner" id="appel_petitioner" 
                            class="form-control" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill out name of the Appellant/Petitioner.</div>
                </div>
            </div>

            <!--
            <div class="row">
                <div class="col-sm-4 mx-auto">--Versus--</div>
            </div>
            -->
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="respondant_opp" class="control-label">Respondent/Opposite Party (*):</label>
                </div>
                <div class="col-sm-6">
                     <input type="text" name="respondant_opp" id="respondant_opp" class="form-control" required/>
                     <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill out name of the Respondent/Opposite Party.</div>
                </div>
            </div>

            <div class="row" >
                <div class="col-sm-4">
                    <label for="certificate_type_id" class="control-label">Certificate type  (*):</label>
                </div>
                <div class="col-sm-6">
                    <select class="custom-select small_font" name="certificate_type_id" id="certificate_type_id" onchange="changeType(this.value)" required>

                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please select Certificate type.</div>
                </div>
            </div>
            <div class="row" id="order_date_layout">
                <div class="col-sm-4">
                    <label for="order_date" class="control-label">Date of Order/Disposal (*):</label>
                </div>
                <div class="col-md-6" >
                    <div class="input-group mb-3">
                        <input type="text" name="order_date" id="order_date" class="form-control date_picker" required/>
                        <span class="input-group-append" >
                            <label class="input-group-text" for="order_date"><i class="fa fa-calendar"></i></label>
                        </span> 
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please fill your Date of Order or Disposal.</div>
                    </div>
                </div>
            </div>
            
            <div style="display:none" id="write_application_area">
                <div>
                    <p> Write your application below (*):</p>
                    <div style="width:100%; height:90%">
                        <textarea class="tinymce" id="textData" name="textData" class="form-control" required></textarea>
                        <div class="valid-feedback" id="aadhar_valid"></div>
                        <div class="invalid-feedback" id="aadhar_invalid">Don't submit blank application.</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4" style="text-align: right"></div>
                <div class="col-sm-6">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" onclick="enableSubmitButton(this);"
                               name="agree" id="agree" required/>
                        <label class="custom-control-label" for="agree" 
                               style="font-size: 10pt;font-style:oblique;color: #005cbf;cursor: pointer ">
                        I confirm that the information I am submitting is true and correct up to my knowledge. And I 
                        bear the responsibility of the correctness of the above information. 
                        </label>
                    </div>
                    <div class="alert alert-warning">
                        #Note: Application once submitted cannot be changed
                    </div>
                </div>
            </div>
            <center>
                <button id="submit_application" type="submit" class="btn btn-secondary" disabled>Submit</button>
            </center>
        </form>
    </div>
    
    <div id="submission_result" class="alert alert-success" 
         style="margin-bottom: 50px; text-align: center; display:none"></div>
</div>
<script type="text/javascript">
    function enableSubmitButton(obj){
        //alert(obj.checked);
        if(obj.checked == true){
            document.getElementById("submit_application").disabled = false;
        }
        else{
            document.getElementById("submit_application").disabled = true;
        }
    }
    //var case_type_options = document.getElementById("case_type");
    function displayCaseTypeOptions() {
        var x = document.getElementById("case_type");
        var txt = "All options: ";
        var i;
        var cases = [];
        var j=0;
        for (i = 0; i < x.length; i++) {
            //txt = txt + "\n" + x.options[i].value+") "+x.options[i].innerHTML;
            if(x.options[i].value.trim()!==""){
                cases[j++] = {"case_id":parseInt(x.options[i].value),"case_name":x.options[i].innerHTML.trim()};
            }
        }
        alert(JSON.stringify(cases));
    }
    document.forms["application_form"].onsubmit = function(event){
        event.preventDefault();
        if(!validateForm()){
            return false;
        }
        submitApplication();
    };

    $(document).ready(function(){
        $("#aadhaar").inputmask({"mask": "9999 9999 9999"});
        $("#aadhaar_otp").inputmask({"mask": "999999"});
        $("#order_date").inputmask({"mask": "99/99/9999"});
        
        $('.date_picker').datepicker({
            format: 'dd/mm/yyyy',
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        
        getCertificateTypes();
    });
    embed_text_editor();
    function embed_text_editor(){
        tinymce.init({ 
            selector:'textarea.tinymce',
            height:450,
            plugins: ["textcolor","link"],
            toolbar: 'insertfile undo redo | styleselect | bold italic | '+
                            'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | '+
                            'link | fontsizeselect | forecolor backcolor',
            default_link_target: "_blank",
            link_title: false,
            branding: false,
            link_assume_external_targets: true,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,'+
                                    'monospace;AkrutiKndPadmini=Akpdmi-n'	
        });
    }

    function changeType(val){
        //$("#order_date").attr("required","");
        if(val == "1"){
            $("#write_application_area").hide();
            //$("#order_date_layout").show();

        }
        else{
            $("#write_application_area").show();
            //$("#order_date_layout").hide();
        }
    }
    function customAlert(message){
        
        Swal.fire({
            title: message,
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        });
    }
    /* Form validation part*/
    function validateForm(){
        var case_type = $("#case_type").val().trim();
        var case_no = $("#case_no").val().trim();
        var case_year = $("#case_year").val().trim();
        var appel_petitioner = $("#appel_petitioner").val().trim();
        var respondant_opp = $("#respondant_opp").val().trim();
        var textData = (tinyMCE.get('textData').getContent()).trim();//$("#textData").val().trim();
        var certificate_type_id = $("#certificate_type_id").val().trim();

        var order_date = $("#order_date").val().trim();
        
        //aadhaar = aadhaar.replace(/\s+|_+/g, '');
        if(certificate_type_id === ""){
            //customAlert("Please select Certificate type");
            //$("#certificate_type_id").attr("class","form-control invalid");
            document.getElementById("certificate_type_id").focus();
            return false;
        }
        else if(certificate_type_id !== "1" && textData === ""){
            $("#textData").attr("class","form-control invalid");
            customAlert("Please write your application.");
            return false;
        }
        
        if(case_type === "" || case_no === "" || case_year === "" || appel_petitioner === "" || respondant_opp === "" || order_date === ""){
            return false;
        }
        return true;
    }
    
    function submitApplication(){
        //var applnForm = new FormData(document.forms["application_form"]);
        var urgent_ordinary = $("#urgent_ordinary").val().trim();
        var case_type = $("#case_type").val().trim();
        var case_no = $("#case_no").val().trim();
        var case_year = $("#case_year").val().trim();
        var case_type_reference = $("#case_type_reference").val().trim();
        var case_no_reference = $("#case_no_reference").val().trim();
        var case_year_reference = $("#case_year_reference").val().trim();
        var appel_petitioner = $("#appel_petitioner").val().trim();
        var respondant_opp = $("#respondant_opp").val().trim();
        var textData = (tinyMCE.get('textData').getContent()).trim();//$("#textData").val().trim();
        var certificate_type_id = $("#certificate_type_id").val().trim();
        var order_date = $("#order_date").val().trim();
        var csrf_token = $("#csrf_token").val().trim();
        
        var data = {
            urgent_ordinary: urgent_ordinary,
            case_type: case_type,
            case_no: case_no,
            case_year: case_year,
            case_type_reference: case_type_reference,
            case_no_reference: case_no_reference,
            case_year_reference: case_year_reference,
            appel_petitioner: appel_petitioner,
            respondant_opp: respondant_opp,
            textData: textData,
            certificate_type_id: certificate_type_id,
            order_date: order_date,
            csrf_token: csrf_token
        };
        //$("#application_form").serialize();
        $.ajax({
            url: "apply",
            data: data,
            type: "POST",
            /*
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            */
            success: function(resp){
                //customAlert(resp.msg);
                $("#submission_result").show();
                $("#submission_result").html(resp.msg);
                $("#otp_verify_layout").hide();
                if(resp.status === true){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg+"\n Redirecting to view page ...",
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.assign("viewApplications");
                        }
                    });
                    
                }
                else{
                    $("#submission_result").attr("class","alert alert-warning");
                }
            },
            error: function (jqXHR, exception, errorThrown) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } 
                else{
                    var resp = JSON.parse(jqXHR.responseText);
                    msg = resp.msg;
                }
                swal.fire({
                    title: 'Error',
                    text: msg,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function getCertificateTypes(){
        var args = {
            url   :   "getCertificateTypes",
            param :   "",
            type  :   "JSON",
            method:   "GET"
        };
        var resp = ajax_request(args);
        if(resp.status === true){
            var cert_list = resp.data;
            /*** displaying certificate type list ***/
            //certificate_type_id
            var layout="<option value='' selected>-- Select --</option>";
            for(var i=0; i<cert_list.length; i++){
                layout += "<option value='"+cert_list[i].certificate_type_id+"'>"+cert_list[i].copy_name+"</option>";
            }
            $("#certificate_type_id").html(layout);
        }
        else{
            alert(resp.msg);
        }
    }
</script>
